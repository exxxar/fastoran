<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{

    protected $table = "menu_category";

    protected $fillable = [
        'name',
        'sort',
    ];

    protected $appends = ["in_category_count"];

    public function getInCategoryCountAttribute(){
        return $this->restoran()->with(["menus"])->count();
    }

    public function menu()
    {
        return $this->hasMany(RestMenu::class, 'food_category_id', 'id');
    }

    public function restorans()
    {
        return $this->belongsToMany(Restoran::class, 'restoran_in_categories', 'restoran_id', 'category_id')
            ->withTimestamps();
    }

}
