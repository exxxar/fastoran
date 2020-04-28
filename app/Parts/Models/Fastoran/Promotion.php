<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $dates = [
        'start_at', 'end_at'
    ];

    protected $fillable = [
        'title',
        'img_url',
        'description',
        'old_price',
        'start_at',
        'end_at',
        'active'
    ];

    public function promocodes()
    {
        return $this->hasMany(RestMenu::class, 'promotion_id', 'id');
    }
}
