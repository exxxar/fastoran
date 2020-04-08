<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "order_details";

    protected $fillable = [
        'product_id',
        'count',
        'price',
        'order_id',
        'more_info'
    ];

    public function product()
    {
        return $this->hasOne(RestMenu::class, 'id', 'product_id');
    }
}
