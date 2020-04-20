<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $table = "order_details";

    protected $casts = [
        'product_details' => 'array',
    ];

    protected $fillable = [
        'product_details',
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
