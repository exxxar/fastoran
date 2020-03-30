<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class MenuRazdel extends Model
{

    public function menu()
    {
        return $this->hasMany(RestMenu::class, 'food_razdel_id', 'id');
    }
}
