<?php

use App\Parts\Models\Fastoran\Restoran;
use Illuminate\Database\Seeder;

class RestoransTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        foreach (Restoran::all() as $restoran)
            $restoran->delete();

       foreach (\App\Parts\Models\Fastoran\Kitchen::all() as $kitchen){

           for ($i=0;$i<10;$i++) {
               $rest = Restoran::create([
                   'name'=>"test $i",
                   'category'=>$i,
                   'adress'=>"test $i",
                   'orientir'=>"test $i",
                   'city'=>$i,
                   'region_id'=>$i,
                   'phone1'=>"test $i",
                   'phone2'=>"test $i",
                   'www'=>"test $i",
                   'mail'=>"test $i",
                   'tim'=>"test $i",
                   'checkout'=>$i,
                   'dance'=>true,
                   'karaoke'=>true,
                   'wifi'=>true,
                   'bussines'=>true,
                   'parking'=>true,
                   'children'=>true,
                   'remark'=>true,
                   'cont_face'=>10,
                   'cont_phone'=>10,
                   'vk_page'=>'',
                   'odn_page'=>'',
                   'inst_page'=>'',
                   'logo'=>'https://sun9-6.userapi.com/c855136/v855136562/190956/65SVD7qyzMI.jpg',
                   'money'=>0,
                   'rating'=>0,
                   'seo_domen'=>'',
                   'seo_title'=>'',
                   'seo_h1'=>'',
                   'seo_description'=>'',
                   'url'=>'',
                   'view'=>true,
                   'comments'=>0,
                   'images'=>0,
                   'reg_dat'=>\Carbon\Carbon::now(),
                   'rest_like'=>0,
                   'rest_antilike'=>0,
                   'rest_img'=>'',
                   'moderation'=>1,
                   'tarif'=>0,
                   'fav'=>'',
                   'manager'=>0,
                   'count_people'=>0,
                   'special'=>0,
                   'discount'=>0,
                   'dir_mail'=>'',
                   'bron_phone'=>'',
                   'discount_text'=>'',
                   'phone_view'=>0,
                   'child'=>0,
                   'min_sum'=>0,
                   'price_delivery'=>0,
                   'time_delivery'=>0,
                   'filters'=>0,
                   'fastoran_money'=>0,
                   'sms'=>0,
                   'start_lanch'=>0,
                   'end_lanch'=>0,
               ]);

               $kitchen->restorans()->attach($rest->id);
           }

       }

    }
}
