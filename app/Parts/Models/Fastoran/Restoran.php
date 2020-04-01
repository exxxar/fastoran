<?php

namespace App\Parts\Models\Fastoran;

use App\Enums\ContentTypeEnum;
use App\Rating;
use App\RestLike;
use Illuminate\Database\Eloquent\Model;

class Restoran extends Model
{
    //

    protected $fillable = [
        'name',
        'description',

        'adress',
        'orientir',

        'city',

        'region',

        'phone1',
        'phone2',

        'site',
        'email',
        'work_time',

        'has_dance',
        'has_karaoke',
        'has_wifi',
        'has_parking',
        'has_business',
        'has_children',
        'has_special',


        'telegram_channel',
        'cont_face',
        'cont_phone',
        'vk_page',
        'odn_page',
        'inst_page',

        'logo',

        'rest_rating',
        'seo_domain',
        'seo_title',
        'seo_h1',
        'seo_description',
        'url',
        'view_count',
        'rest_img',
        'moderation',
        'tarif',
        'discount',
        'discount_text',
        'min_sum',
        'price_delivery',
        'fastoran_money',
        'rating_id',

    ];

     protected $appends = ["comments_count","rating"];

    public function getCommentsCountAttribute(){
        return 0;
    }

    public function kitchens()
    {
        return $this->belongsToMany(Kitchen::class, 'kitchen_in_restorans', 'kitchen_id', 'restoran_id')
            ->withTimestamps();
    }

    public function menus()
    {
        return $this->hasMany(RestMenu::class, 'rest_id', 'id');
    }

    public function region()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    public function getRatingAttribute()
    {
        return Rating::where("content_type", ContentTypeEnum::Restoran)
            ->select(["dislike_count","like_count"])
            ->where('content_id', $this->id)
            ->first();
    }
}
