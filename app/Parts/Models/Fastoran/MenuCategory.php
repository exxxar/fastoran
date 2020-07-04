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

    protected $appends = ["in_category_count", "alias","sort_index"];


    public function getInCategoryCountAttribute()
    {
        return $this->restorans()->count();
    }

    public function getAliasAttribute()
    {
        return /*mb_substr($this->name, 1);//*/$this->table . "_" . $this->id;
    }

    public function getSortIndexAttribute(){
        $arr = array();
        $str = mb_strtolower($this->name);
        $strLen = mb_strlen($str, 'UTF-8');
        for ($i = 0; $i < $strLen; $i++)
        {
            $arr[] = mb_substr($str, $i, 1, 'UTF-8');
        }

        return mb_ord($arr[1]);
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
