<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObedyGoCategory extends Model
{
    //

    protected $fillable = [
        'title',
        'description'
    ];

    public function products()
    {
        return $this->hasMany(ObedyGoProduct::class, 'category_id', 'id');
    }
}
