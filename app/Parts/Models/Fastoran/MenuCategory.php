<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuCategory extends Model
{
    use SoftDeletes;
    protected $table = "menu_category";

    protected $fillable = [
        'name',
        'sort',
    ];

    protected $appends = ["in_category_count", "alias"];


    public function getInCategoryCountAttribute()
    {
        return $this->restorans()->count();
    }

    public function getAliasAttribute()
    {
        return /*mb_substr($this->name, 1);//*/$this->table . "_" . $this->id;
    }

    public function getFilteredMenu($restId)
    {
        return $this->menus->filter(function ($prod) use ($restId) {
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
