<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsQueue extends Model
{
    //
    protected $fillable = [
        "phone", "status","message"
    ];

}
