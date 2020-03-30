<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{

    protected $fillable = [
        'name',
        'rest_id',
        'sort',
    ];

    protected $appends = ["in_category_count"];

    public function getInCategoryCountAttribute(){
        return $this->restoran()->with(["menus"])->count();
    }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'food_category_id', 'id');
    }

    public function restoran()
    {
        return $this->hasOne(Restoran::class, 'id', 'rest_id');
    }
}
