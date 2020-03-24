<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestLike extends Model
{
    //

    protected $table = "like_rest";

    protected $fillable = [
        'ip',
        'likes',
        'antilikes',
        'rest_id',
        'dat',
    ];
}
