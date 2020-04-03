<?php

namespace App\Parts\Models\Fastoran;

use App\Classes\Utilits;
use App\Enums\ContentTypeEnum;
use App\User;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use CastsEnums, Utilits;

    protected $enumCasts = [
        'status' => ContentTypeEnum::class,
    ];


    protected $fillable = [
        'rest_id',
        'user_id',
        'deliveryman_id',

        'latitude',
        'longitude',

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

        'created_at'
    ];

    protected $appends = ["summary_count", "summary_price", "restoran_name";

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function deliveryman()
    {
        return $this->hasOne(User::class, 'id', 'deliveryman_id');
    }


    public function restoran()
    {
        return $this->hasOne(Restoran::class, 'id', 'rest_id');
    }

    public function getRestoranNameAttribute()
    {
        return ($this->restoran()->first())->name;
    }

    public function getSummaryCountAttribute()
    {
        return $this->details()->sum("count");
    }

    public function getSummaryPriceAttribute()
    {
        $restoran = $this->restoran()->first();

        $range = ($this->calculateTheDistance($this->latitude, $this->longitude, $restoran->latitude, $restoran->longitude) / 1000);

        $order_sum =  $this->details()->where("order_id",$this->id)->sum("price");

        return  $order_sum + ceil(env("BASE_DELIVERY_PRICE") + ($range * env("BASE_DELIVERY_PRICE_PER_KM")));
    }
}
