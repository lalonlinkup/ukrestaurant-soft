<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id')->select('id', 'name');
    }

    public static function supplierDue($request)
    {
        try {
            $request = (object)$request;
            $date = !empty($request->date) ? $request->date : null;
            $clauses = "";
            if (isset($request->supplierId) && $request->supplierId != null) {
                $clauses .= " and s.id = '$request->supplierId'";
            }
            if (isset($request->districtId) && $request->districtId != null) {
                $clauses .= " and s.district_id = '$request->districtId'";
            }

            $query = DB::select("
                    select
                        s.id,
                        s.code,
                        s.name,
                        s.owner_name,
                        s.phone,
                        s.address,
                        ifnull(d.name, '') as areaName,
                        (select (ifnull(sum(pm.total), 0.00) + ifnull(s.previous_due, 0.00)) from purchases pm
                            where pm.supplier_id = s.id
                            " . ($date == null ? "" : " and pm.date < '$date'") . "
                            and pm.status = 'a'
                        ) as assetBill,
    
                        (select ifnull(sum(pm2.paid), 0.00) from purchases pm2
                            where pm2.supplier_id = s.id
                            " . ($date == null ? "" : " and pm2.date < '$date'") . "
                            and pm2.status = 'a'
                        ) as assetPurchsePaid,

                        (select (ifnull(sum(mp.total), 0.00)) from material_purchases mp
                            where mp.supplier_id = s.id
                            " . ($date == null ? "" : " and mp.date < '$date'") . "
                            and mp.status = 'a'
                        ) as materialPurchaseBill,
    
                        (select ifnull(sum(mp2.paid), 0.00) from material_purchases mp2
                            where mp2.supplier_id = s.id
                            " . ($date == null ? "" : " and mp2.date < '$date'") . "
                            and mp2.status = 'a'
                        ) as materialPurchasePaid,

                        (select assetPurchsePaid + materialPurchasePaid) as invoicePaid,

                        (select assetBill + materialPurchaseBill) as bill,
    
                        (select ifnull(sum(sp.amount), 0.00) from supplier_payments sp 
                            where sp.supplier_id = s.id 
                            and sp.type = 'CP'
                            " . ($date == null ? "" : " and sp.date < '$date'") . "
                            and sp.status = 'a'
                        ) as cashPaid,
                            
                        (select ifnull(sum(sp2.amount), 0.00) from supplier_payments sp2 
                            where sp2.supplier_id = s.id 
                            and sp2.type = 'CR'
                            " . ($date == null ? "" : " and sp2.date < '$date'") . "
                            and sp2.status = 'a'
                        ) as cashReceived,
    
                        
                        (select invoicePaid + cashPaid) as paid,
                        
                        (select (bill + cashReceived) - (paid)) as due
                        
                    from suppliers s
                    left join districts d on d.id = s.district_id
                    where s.status = 'a' 
                    $clauses");
            return $query;
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }

        // (select ifnull(sum(pr.amount), 0.00) from purchase_returns pr
        //                     where pr.supplier_id = s.id
        //                     and pr.status = 'a'
        //                     " . ($date == null ? "" : " and pr.date < '$date'") . "
        //                 ) as returned,
    }
}
