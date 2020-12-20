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
        'is_activated',
        'lottery_id'
    ];
}
