<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    //

    protected $fillable = [
        'bot_url',
        'token_prod',
        'token_dev',
        'description',
        'bot_pic',
        'is_active',
        'money',
        'money_per_day',
    ];
}
