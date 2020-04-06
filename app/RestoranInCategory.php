<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestoranInCategory extends Model
{
    //

    protected $fillable = [
        'category_id',
        'restoran_id'
    ];
}
