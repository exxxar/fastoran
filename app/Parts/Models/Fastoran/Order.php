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
        "delivery_note",
    ];

    protected $appends = ["summary_count","summary_price"];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }


    public function restoran()
    {
        return $this->hasOne(Restoran::class, 'id', 'rest_id');
    }

    public function getSummaryCountAttribute(){
        return $this->details()->sum("count");
    }

    public function getSummaryPriceAttribute(){
        return $this->details()->sum("price");
    }
}
