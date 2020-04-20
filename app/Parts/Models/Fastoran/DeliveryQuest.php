<?php

namespace App\Parts\Models\Fastoran;

use App\Classes\Utilits;
use App\Enums\OrderStatusEnum;
use App\User;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryQuest extends Model
{


    protected $fillable = [
        'point_a',
        'point_b',
        'next_quest_id',
        'quest_type',
        'description',
        'range',
        'price',
        'order_id',
    ];

    protected $casts = [
        'point_a' => 'array',
        'point_b' => 'array',
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function next()
    {
        return $this->hasOne(DeliveryQuest::class, 'id', 'next_quest_id');
    }
}
