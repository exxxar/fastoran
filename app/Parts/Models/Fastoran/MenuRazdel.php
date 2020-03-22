<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class MenuRazdel extends Model
{
    //

    protected $table = "menu_razdel";

    public function menu()
    {
        return $this->hasMany(Menu::class, 'food_razdel_id', 'id');
    }
}
