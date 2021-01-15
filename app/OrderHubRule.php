<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHubRule extends Model
{
    //
    protected $fillable = [
        'vk_user_id',
        'rest_id',
        'rest_channel_id',
        'admin_channel_id',
        'delivery_channel_id',
        'phone',
        'description',
        'is_admin',
        'is_deliveryman',
        'is_main_admin',
    ];
}
