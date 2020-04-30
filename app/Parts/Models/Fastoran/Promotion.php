<?php

namespace App\Parts\Models\Fastoran;

use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;

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
