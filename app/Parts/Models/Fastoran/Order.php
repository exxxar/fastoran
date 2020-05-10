<?php

namespace App\Parts\Models\Fastoran;

use App\Classes\Utilits;
use App\Enums\ContentTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\OrderTypeEnum;
use App\User;
use BenSampo\Enum\Traits\CastsEnums;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use CastsEnums, Utilits, SoftDeletes;

    protected $enumCasts = [
        'status' => OrderStatusEnum::class,
        'order_type' => OrderTypeEnum::class,
    ];

    protected $casts = [
        'custom_details' => 'array',
    ];

    protected $fillable = [
        'rest_id',
        'user_id',

        'deliveryman_id',
        'deliveryman_latitude',
        'deliveryman_longitude',

        'latitude',
        'longitude',

        'status',
        'order_type',

        'delivery_price',
        'delivery_range',
        'delivery_note',
        'take_by_self',

        'receiver_name',
        'receiver_phone',

        'receiver_delivery_time',
        'receiver_address',
        'receiver_order_note',
        'receiver_domophone',

        'custom_details',

        'client',
        'created_at'
    ];

    protected $appends = ["summary_count", "summary_price", "status_text", "delivered_time"];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function quests()
    {
        return $this->hasMany(DeliveryQuest::class, 'order_id', 'id');
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

    public function getDeliveredTimeAttribute()
    {

        $delivery_time = (is_null($this->delivery_note) ? 0 : intval($this->delivery_note))*2;

        $time = max($this->delivery_range, 10) + $delivery_time;

        return Carbon::parse($this->created_at, '+3:00')->addMinutes($time)->format('H:i') .
            " - " .
            Carbon::parse($this->created_at, '+3:00')->addMinutes($time + 10)->format('H:i');

    }

    public function getStatusTextAttribute()
    {
        $delivery_time = (is_null($this->delivery_note) ? 0 : intval($this->delivery_note))*2;

        $time = "Не установлено";
        if (!is_null($this->delivery_note))
            $time = sprintf("%.0f", max($this->delivery_range, 10) + $delivery_time);
        switch (intval(OrderStatusEnum::getInstance($this->status)->value)) {
            default:
            case 0:
                return "В обработке";
            case 1:
                return "Готовится (время готовности $this->delivery_note мин.)";
            case 2:
                return "Доставляется (время доставки $time мин.)";
            case 3:
                return "Доставлено";
        }


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
