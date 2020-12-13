<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObedyGoProduct extends Model
{

    protected $fillable = [
        'title',
        'description',
        'day_index',
        'image',
        'price',
        'weight',
        'category_id',
        'food_part_id',
        'positions',
        'checked',
        'is_week',
        'disabled',
        'addition'

    ];

    protected $casts = [
        "positions" => "array"
    ];

    public function category()
    {
        return $this->hasOne(ObedyGoCategory::class, 'id', 'category_id');
    }
}
