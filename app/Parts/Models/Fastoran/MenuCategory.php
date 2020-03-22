<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    //

    protected $table = "menu_category";

    protected $fillable = [
        'name',
        'rest_id',
        'business',
        'sort',
    ];

    public function menu()
    {
        return $this->hasMany(Menu::class, 'food_category_id', 'id');
    }

    public function restoran()
    {
        return $this->hasOne(Restoran::class, 'id', 'rest_id');
    }
}
