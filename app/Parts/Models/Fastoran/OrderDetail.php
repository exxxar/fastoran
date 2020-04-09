<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $table = "order_details";

    protected $fillable = [
        'product_id',
        'count',
        'price',
        'order_id'
    ];

    public function product()
    {
        return $this->hasOne(RestMenu::class, 'id', 'product_id');
    }
}
