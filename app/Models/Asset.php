<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function brand() {
        return $this->belongsTo(Brand::class)->select('id', 'name');
    }

    public function unit() {
        return $this->belongsTo(Unit::class)->select('id', 'name');
    }

    public static function getStock($request)
    {
        try {
            $request = (object) $request;
            $date = null;
            $clauses = "";
            if (!empty($request->date)) {
                $date = $request->date;
            }

            if (!empty($request->assetId)) {
                $clauses .= "and a.id ='$request->assetId'";
            }
            if (!empty($request->brandId)) {
                $clauses .= "and a.brand_id ='$request->brandId'";
            }

            $stock = DB::select("
                    select
                    a.*,
                    b.name as brand_name,
                    u.name as unit_name,
                    (select ifnull(sum(pd.quantity), 0) 
                        from purchase_details pd 
                        join purchases pm on pm.id = pd.purchase_id
                        where pd.asset_id = a.id
                        and pd.status = 'a'
                        " . (isset($date) && $date != null ? " and pm.date <= '$date'" : "") . "
                    ) as purchased_quantity,
                            
                    (select ifnull(sum(id.quantity), 0) 
                        from issue_details id
                        join issues i on i.id = id.issue_id
                        where id.asset_id = a.id
                        and id.status = 'a'
                        " . (isset($date) && $date != null ? " and i.date <= '$date'" : "") . "
                    ) as issue_quantity,
                            
                    (select (purchased_quantity) - (issue_quantity)) as current_quantity,
                    (select replace(a.price, ',', '') * current_quantity) as stockValue
                from assets a
                left join brands b on b.id = a.brand_id
                left join units u on u.id = a.unit_id
                where a.status = 'a' and a.is_active = true $clauses
                order by a.id asc
                ");

            return $stock;
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

//     (select ifnull(sum(ird.quantity), 0)
//     from issue_return_details ird 
//     join issue_returns ir on ir.id = ird.issue_return_id
//     where ird.asset_id = a.id
//     and ird.status = 'a'
//     " . (isset($date) && $date != null ? " and ir.date <= '$date'" : "") . "
// ) as issue_returned_quantity,
}
