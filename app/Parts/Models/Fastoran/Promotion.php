<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $casts = [
        'product' => 'array',
    ];

    protected $fillable = [
        'discount',
        'product',
        'active'
    ];

    public function promocodes()
    {
        return $this->hasMany(RestMenu::class, 'promotion_id', 'id');
    }
}
