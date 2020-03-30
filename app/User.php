<?php

namespace App;

use App\Enums\UserTypeEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Enum\Laravel\HasEnums;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasEnums;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $enums = [
        'user_type' => UserTypeEnum::class,
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'auth_code',
        'user_type',
        'telegram_chat_id',
        'birthday',
        'bonus',
        'adress',
        'social',
        'active',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
