<?php

namespace App;

use App\Enums\DeliveryTypeEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $enums = [
        'user_type' => UserTypeEnum::class,
        'deliveryman_type' => DeliveryTypeEnum::class,
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'auth_code',
        'user_type',
        'deliveryman_type',
        'telegram_chat_id',
        'birthday',
        'bonus',
        'adress',
        'social',
        'active',
        'password',
        'trusted_count',
        'trusted_limit',
        'is_trusted',
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
