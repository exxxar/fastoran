<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class MenuRubrik extends Model
{
    //

    public function menu()
    {
        return $this->hasMany(Menu::class, 'food_rubr_id', 'id');
    }
}
