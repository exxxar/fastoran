<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotteryPromocode extends Model
{
    //

    protected $fillable = [
        'code',
        'name',
        'phone',
        'email',
        'max_activation_count',
        'current_activation_count',
        'lottery_id'
    ];

    protected $appends = [
        "is_activated"
    ];

    public function getIsActivatedAttribute()
    {
        return $this->current_activation_count == $this->max_activation_count;
    }
}
