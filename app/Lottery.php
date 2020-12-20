<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lottery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image',
        'title',
        'description',
        'occuped_places',
        'place_count',
        'free_place_count',
        'is_active',
        'is_complete',
        'date_end',
    ];

    protected $casts = [
        "occuped_places" => "array"
    ];
}
