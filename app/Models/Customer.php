<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id')->select('id', 'name');
    }

    public function reference()
    {
        return $this->belongsTo(Reference::class, 'reference_id', 'id')->select('id', 'name', 'code');
    }


    public static function customerDue($clauses)
    {

        $due = DB::select("select 
                            bkm.id,
                            bkm.invoice,
                            bkm.total,
                            c.id as customer_id,
                            c.name,
                            c.phone,
                            (select ifnull(sum(om.total), 0) from orders om 
                            where om.booking_id = bkm.id and om.status = 'a') as orderAmount,
                            (select ifnull(sum(sm.amount), 0) from services sm 
                            where sm.booking_id = bkm.id and sm.status = 'a') as serviceAmount,
                            (select bkm.total + orderAmount + serviceAmount) as billAmount,
                            (select ifnull(sum(crp.amount), 0) from customer_payments crp 
                            where crp.booking_id = bkm.id and crp.status = 'a') as cusPayment,
                            (select ifnull(sum(crp.discountAmount), 0) from customer_payments crp 
                            where crp.booking_id = bkm.id and crp.status = 'a') as discountAmount,
                            (select bkm.advance + cusPayment) as paymentAmount,
                            (select billAmount - (paymentAmount + discountAmount)) as dueAmount
                            from booking_masters bkm
                            left join customers c on c.id = bkm.customer_id
                            where bkm.status = 'a'
                        $clauses");

        return $due;
    }
    // public static function customerDue($clauses)
    // {

    //     $due = DB::select("select
    //                     c.code,
    //                     c.name,
    //                     c.phone,
    //                     (select ifnull(sum(bkm.total), 0) from booking_masters bkm 
    //                     where bkm.customer_id = c.id and bkm.status = 'a') as bill,
    //                     (select ifnull(sum(bkm.advance), 0) from booking_masters bkm 
    //                     where bkm.customer_id = c.id and bkm.status = 'a') as advance,
    //                     (select ifnull(sum(s.amount), 0) from services s 
    //                     where s.customer_id = c.id and s.status = 'a') as serviceAmount,
    //                     (select ifnull(sum(om.total), 0) from orders om 
    //                     where om.customer_id = c.id and om.status = 'a') as orderAmount,
    //                     (select ifnull(sum(crp.amount), 0) from customer_payments crp 
    //                     where crp.customer_id = c.id and crp.status = 'a') as paymentAmount,
    //                     (select advance + paymentAmount) as totalPayment,
    //                     (select (bill + serviceAmount + orderAmount) - totalPayment) as due
    //                     from customers c
    //                     where c.status = 'a'
    //                     $clauses");

    //     return $due;
    // }
}
