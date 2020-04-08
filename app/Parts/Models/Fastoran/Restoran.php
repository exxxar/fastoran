<?php

namespace App\Parts\Models\Fastoran;

use App\Enums\ContentTypeEnum;
use App\Rating;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Restoran extends Model
{
    //

    protected $fillable = [
        'name',
        'description',

        'latitude',
        'longitude',

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

    protected $appends = ["comments_count", "rating", "kitchen_speicalization", "categories_speicalization", "is_work"];


    public function getCommentsCountAttribute()
    {
        return 0;
    }

    public function getIsWorkAttribute()
    {
        $start_time = explode('-', $this->work_time)[0];
        $end_time = explode('-', $this->work_time)[1];

        return strtotime($start_time) <= time() && time() <= strtotime($end_time);
    }

    public function categories()
    {
        return $this->belongsToMany(MenuCategory::class, 'restoran_in_categories', 'restoran_id', 'category_id')
            ->withTimestamps();
    }

    public function kitchens()
    {
        return $this->belongsToMany(Kitchen::class, 'kitchen_in_restorans', 'restoran_id', 'kitchen_id')
            ->withTimestamps();
    }

    public function menus()
    {
        return $this->hasMany(RestMenu::class, 'rest_id', 'id');
    }

    public function getCategoriesSpeicalizationAttribute()
    {
        $categories = $this->categories()->get();
        $tmp = "";
        foreach ($categories as $key => $k)
            $tmp .= $k->name . ", ";

        return $tmp;
    }

    public function getKitchenSpeicalizationAttribute()
    {
        $kitchens = $this->kitchens()->get();
        $tmp = "";
        foreach ($kitchens as $key => $k)
            $tmp .= "#" . $k->name . ", ";

        return $tmp;
    }


    public function getRatingAttribute()
    {
        return Rating::where("content_type", ContentTypeEnum::Restoran)
            ->select(["dislike_count", "like_count"])
            ->where('content_id', $this->id)
            ->first();
    }
}
