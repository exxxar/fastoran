<?php

namespace App;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;

class BotUserInfo extends Model
{
    protected $table = "bot_user_info";

    protected $fillable = [
        'chat_id',
        'account_name',
        'fio',
        'cash_back',
        'phone',
        'is_vip',
        'is_admin',
        'is_developer',
        'is_working',
        'parent_id',
        'user_id'
    ];


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function parent()
    {
        return $this->hasOne(BotUserInfo::class, 'id', 'parent_id');
    }
}
