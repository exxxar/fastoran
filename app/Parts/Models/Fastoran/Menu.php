<?php

namespace App\Parts\Models\Fastoran;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = "menu";

    protected $fillable = [
        'food_name',
        'food_remark',
        'food_ext',
        'food_price',
        'food_rubr_id',
        'food_razdel_id',
        'rest_id',
        'food_category_id',
        'food_img',
        'bonus',
        'stop_list',
    ];

    public function category()
    {
        return $this->hasOne(MenuCategory::class, 'id', 'food_category_id');
    }

    public function rubrik()
    {
        return $this->hasOne(MenuRubrik::class, 'id', 'food_rubr_id');
    }

    public function razdel()
    {
        return $this->hasOne(MenuRazdel::class, 'id', 'food_razdel_id');
    }
}
