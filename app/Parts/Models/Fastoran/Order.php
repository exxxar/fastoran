<?php

namespace App\Parts\Models\Fastoran;

use App\Classes\Utilits;
use App\Enums\ContentTypeEnum;
use App\Enums\OrderStatusEnum;
use App\User;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use CastsEnums, Utilits;

    protected $enumCasts = [
        'status' => OrderStatusEnum::class,
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

    protected $appends = ["summary_count", "summary_price", "restoran_name", "status_text"];

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

    public function getStatusTextAttribute()
    {

        switch (intval(OrderStatusEnum::getInstance($this->status)->value)) {
            default:
            case 0:
                return "В обработке";
            case 1:
                return "Готовится";
            case 2:
                return "Доставляется";
            case 3:
                return "Доставлено";
        }
    }

    public function getRestoranNameAttribute()
    {
        return $this->restoran->name??"Empty";
    }

    public function getSummaryCountAttribute()
    {
        $tmp_sum = 0;

        foreach ($this->details()->get() as $d) {
            $tmp_sum += $d->count;
        }

        return $tmp_sum;
    }

    public function getSummaryPriceAttribute()
    {
        $tmp_sum = 0;

        foreach ($this->details()->get() as $d) {
            $tmp_sum += $d->count * $d->price;
        }
        return $tmp_sum;
    }
}
