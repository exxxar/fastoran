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

    protected $appends = ["in_category_count","alias"];

    public function getInCategoryCountAttribute()
    {
        return $this->restorans()->count();
    }

    public function getAliasAttribute()
    {
        return $this->table . "_" . $this->id;
    }

    public function getFilteredMenu($restId){
        return $this->menus->filter(function ($prod) use ($restId){
            return $prod->rest_id == $restId;
        });
    }

    public function menus()
    {
        return $this->hasMany(RestMenu::class, 'food_category_id', 'id');
    }

    public function restorans()
    {
        return $this->belongsToMany(Restoran::class, 'restoran_in_categories', 'category_id', 'restoran_id')
            ->withTimestamps();
    }

}
