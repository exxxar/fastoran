<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //

    protected $table = "region";

    protected $fillable = [
        'city',
        'name'
    ];

}
