<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function unit() {
        return $this->belongsTo(Unit::class)->select('id', 'name');
    }

    public static function getMaterialStock($request) {
        try {
            $request = (object) $request;
            $date = null;
            $clauses = "";
            if (!empty($request->date)) {
                $date = $request->date;
            }

            if (!empty($request->materialId)) {
                $clauses .= "and m.id ='$request->materialId'";
            }

            $stock = DB::select("
                    select
                    m.*,
                    u.name as unit_name,
                    (select ifnull(sum(mpd.quantity), 0) 
                        from material_purchase_details mpd 
                        join material_purchases mp on mp.id = mpd.material_purchase_id
                        where mpd.material_id = m.id
                        and mpd.status = 'a'
                        " . (isset($date) && $date != null ? " and mp.date <= '$date'" : "") . "
                    ) as purchased_quantity,
                            
                    (select ifnull(sum(pd.quantity), 0) 
                        from production_details pd
                        join productions p on p.id = pd.production_id
                        where pd.material_id = m.id
                        and pd.status = 'a'
                        " . (isset($date) && $date != null ? " and p.date <= '$date'" : "") . "
                    ) as production_quantity,
                            
                    (select (purchased_quantity) - (production_quantity)) as current_quantity,
                    (select replace(m.price, ',', '') * current_quantity) as stockValue
                from materials m
                left join units u on u.id = m.unit_id
                where m.status = 'a' $clauses
                order by m.id asc
                ");

            return $stock;
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
