<?php

namespace App\Parts\Models\Fastoran;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'active',
        'user_id',
        'promotion_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function promotion()
    {
        return $this->hasOne(Promotion::class, 'id', 'promotion_id');
    }


}
