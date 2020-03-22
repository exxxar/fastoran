<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class MenuRubrik extends Model
{
    //

    protected $table = "menu_rubrik";

    public function menu()
    {
        return $this->hasMany(Menu::class, 'food_rubr_id', 'id');
    }
}
