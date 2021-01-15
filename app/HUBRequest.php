<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HUBRequest extends Model
{
    //

    protected $fillable = [
        'vk_user_id',
        'vk_channel_id',
        'comment',
        'request_type',
        'is_confirmed',
        'is_declined',
    ];
}
