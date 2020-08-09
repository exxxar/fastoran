<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class RestoranInSection extends Model
{
    //
    protected $table = "restorans_in_section";

    protected $fillable = [
        'section_id',
        'restoran_id'
    ];
}
