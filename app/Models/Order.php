<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

protected $fillable = [

    'customer_name',

    'customer_email',

    'payment_method',

    'payment_status',

    'order_status',
    'queue_number',
    'midtrans_order_id',

    'transaction_id',

    'total_price',

    'paid_at'

];

    // ======================
    // RELATION
    // ======================

    public function items()
    {

        return $this->hasMany(

            OrderItem::class

        );

    }

}