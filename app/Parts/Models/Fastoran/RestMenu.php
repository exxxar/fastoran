<?php

namespace App\Parts\Models\Fastoran;

use App\Enums\ContentTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestMenu extends Model
{
    use SoftDeletes;

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
        'rating', 'food_ext', 'rest_info'
    ];

    public function getRestInfoAttribute(){
        return [
          "name"=>$this->restoran->name??'',
           "is_work"=>$this->restoran->is_work??false,
           "work_time"=>$this->restoran->work_time??'',
           "logo"=>$this->restoran->logo??'',
           "url"=>$this->restoran->url??''
        ];
    }
    public function restoran()
    {
        return $this->hasOne(Restoran::class, 'id', 'rest_id');
    }

    public function category()
    {
        return $this->hasOne(MenuCategory::class, 'id', 'food_category_id');
    }

    public function getFoodExtAttribute()
    {
        return ">=100 грамм";
    }

    public function getRatingAttribute()
    {
        return Rating::where("content_type", ContentTypeEnum::Menu)
            ->select(["dislike_count", "like_count"])
            ->where('content_id', $this->id)
            ->first();
    }


}
