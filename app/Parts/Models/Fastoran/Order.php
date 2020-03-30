<?php

namespace App\Parts\Models\Fastoran;

use App\Enums\ContentTypeEnum;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use CastsEnums;

    protected $enumCasts = [
        'status' => ContentTypeEnum::class,
    ];


    protected $fillable = [
        'rest_id',
        'user_id',

        'status',

        'delivery_price',
        'delivery_range',
        'delivery_note',

        'receiver_name',
        'receiver_phone',

        'receiver_delivery_time',
        'receiver_address',
        'receiver_order_note',
        'receiver_domophone',
    ];

    protected $appends = ["summary_count", "summary_price"];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }


    public function restoran()
    {
        return $this->hasOne(Restoran::class, 'id', 'rest_id');
    }

    public function getSummaryCountAttribute()
    {
        return $this->details()->sum("count");
    }

    public function getSummaryPriceAttribute()
    {
        return $this->details()->sum("price");
    }
}
