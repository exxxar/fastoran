<?php

namespace App\Parts\Models\Fastoran;

use App\Enums\ContentTypeEnum;
use App\Rating;
use Illuminate\Database\Eloquent\Model;

class RestMenu extends Model
{


    protected $fillable = [
        'food_name',
        'food_remark',
        'food_ext',
        'food_price',
        'rest_id',
        'food_category_id',
        'food_img',
        'stop_list',
        'rating_id'
    ];

    protected $appends = [
        'rating'
    ];

    public function category()
    {
        return $this->hasOne(MenuCategory::class, 'id', 'food_category_id');
    }

    public function getRatingAttribute()
    {
        return Rating::where("content_type", ContentTypeEnum::Menu)
            ->where('content_id', $this->id)
            ->first();
    }


}
