<?php

namespace App;

use App\Parts\Models\Fastoran\Restoran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $cells
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $cells)
    {
        return new Restoran([

            'name'=>$cells['name']?? '',
            'description'=>$cells['description']?? '',

            'latitude'=>$cells['latitude']?? null,
            'longitude'=>$cells['longitude']?? null,

            'adress'=>$cells['adress']?? '',
            'orientir'=>$cells['orientir'] ?? '',

            'city'=>$cells['city']?? '',

            'region'=>$cells['region']?? '',

            'phone1'=>$cells['phone1']?? '',
            'phone2'=>$cells['phone2']?? '',

            'site'=>$cells['site']?? '',
            'email'=>$cells['email']?? '',
            'work_time'=>$cells['work_time']?? '10:00-20:00',

            'has_dance'=>$cells['has_dance']?? 0,
            'has_karaoke'=>$cells['has_karaoke']?? 0,
            'has_wifi'=>$cells['has_wifi']?? 1,
            'has_parking'=>$cells['has_parking']?? 1,
            'has_business'=>$cells['has_business']?? 1,
            'has_children'=>$cells['has_children']?? 1,
            'has_special'=>$cells['has_special']?? 0,


            'telegram_channel'=>$cells['telegram_channel']?? '',
            'cont_face'=>$cells['cont_face']?? '',
            'cont_phone'=>$cells['cont_phone']?? '',
            'vk_page'=>$cells['vk_page']?? '',
            'odn_page'=>$cells['odn_page']?? '',
            'inst_page'=>$cells['inst_page']?? '',

            'logo'=>$cells['logo']?? '',

            'rest_rating'=>$cells['rest_rating']?? 0,
            'seo_domain'=>$cells['seo_domain']?? '',
            'seo_title'=>$cells['seo_title']?? '',
            'seo_h1'=>$cells['seo_h1']?? '',
            'seo_description'=>$cells['seo_description']?? '',
            'url'=>$cells['url']?? '',
            'view_count'=>$cells['view_count']?? 0,
            'rest_img'=>$cells['rest_img']?? '',
            'moderation'=>$cells['moderation']?? 1,
            'tarif'=>$cells['tarif']?? 0,
            'discount'=>$cells['discount']?? 0,
            'discount_text'=>$cells['discount_text']?? '',
            'min_sum'=>$cells['min_sum']?? 0,
            'price_delivery'=>$cells['price_delivery']?? 0,
            'fastoran_money'=>$cells['fastoran_money']?? 0,
            'rating_id'=>$cells['rating_id']?? null,
        ]);
    }
}
