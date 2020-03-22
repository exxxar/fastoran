<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = "orders";

    protected $fillable = [
        "rest_id",
        "user_id",
        "summ",
        "pers",
        "dat",
        "tim",
        "remark",
        "gosti",
        "sdacha",
        "delivery_price",
        "status",
        "delivery_range",
        "receiver_name",
        "receiver_phone",
        "receiver_region",
        "receiver_delivery_time",
        "receiver_address",
        "receiver_pers",
        "receiver_order_note",
        "receiver_domophone",
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

}
