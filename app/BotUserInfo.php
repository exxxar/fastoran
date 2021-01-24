<?php

namespace App;


use App\Parts\Models\Fastoran\Restoran;
use App\User;
use Illuminate\Database\Eloquent\Model;


class BotUserInfo extends Model
{
    protected $table = "bot_user_info";

    protected $fillable = [
        'chat_id',
        'account_name',
        'fio',
        'cash_back',
        'phone',

        'user_type',
        'is_working',
        'rest_id',
        'bot_id',

        'delivery_city',

        'parent_id',
        'user_id'
    ];


    public function isActive()
    {
        return $this->user_type > 0;
    }

    public function rest()
    {
        return $this->hasOne(Restoran::class, 'id', 'rest_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function parent()
    {
        return $this->hasOne(BotUserInfo::class, 'id', 'parent_id');
    }
}
