<?php

namespace App\Parts\Models\Fastoran;

use App\RestLike;
use Illuminate\Database\Eloquent\Model;

class Restoran extends Model
{
    //

    protected $fillable = [
        'name',
        'description',

        'category_id',

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

     protected $appends = ["likes","dislikes","comments_count"];

    public function getCommentsCountAttribute(){
        return 0;
    }

     public function getLikesAttribute(){
         return 0;
     }

     public function getDislikesAttribute(){
         return 0;
     }

    public function kitchens()
    {
        return $this->belongsToMany(Kitchen::class, 'kitchen_in_restorans', 'kitchen_id', 'restoran_id')
            ->withTimestamps();
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'rest_id', 'id');
    }

    public function region()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }
}
