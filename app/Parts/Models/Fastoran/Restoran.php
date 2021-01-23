<?php

namespace App\Parts\Models\Fastoran;

use App\Enums\ContentTypeEnum;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restoran extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'vk_group_id',

        'latitude',
        'longitude',

        'adress',
        'orientir',

        'city',

        'region',

        'keyword',

        'phone1',
        'phone2',

        'site',
        'email',
        'work_time',

        'work_days', //new
        'banners',//new

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

    protected $appends = ["comments_count", "rating", "section_speicalization", "categories_speicalization", "is_work", "simple_name"];


    public function getCommentsCountAttribute()
    {
        return 0;
    }

    public function getSimpleNameAttribute()
    {
        $names = explode(" ", $this->name);

        $vowels = array("'", "\"");
        $name = str_replace($vowels, "", implode(count($names) == 1 ? $names : array_slice($names, 1)));

        return $name;
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

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'restorans_in_section', 'restoran_id', 'section_id')
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

    public function getSectionSpeicalizationAttribute()
    {
        $sections = $this->sections()->get();
        $tmp = "";
        foreach ($sections as $key => $k)
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
