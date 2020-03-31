<?php

use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\Restoran;
use App\Rating;
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

        $tmp = [];

        $rest = Restoran::create([
            'name' => 'Ресторан "Diner"',
            'description' => '',
            'adress' => 'Театральный проспект, 28, Донецк',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+38(071)07-888-70",
            'phone2' => "+38(071)50-777-05",
            'inst_page' => "diner_dn",
            'site' => "https://diner-dn.ru",
            'telegram_channel' => "-1001401139179",
            'vk_page' => "https://vk.com/diner_dn",
            'logo' => "https://sun2.48276.userapi.com/l9zyjSF3dHhv2YjoDfogufKOwaxYzcxeui79TQ/p_IXY8eyQYo.jpg",
            'url' => "diner",
            'rest_img' => "https://sun2.48276.userapi.com/l9zyjSF3dHhv2YjoDfogufKOwaxYzcxeui79TQ/p_IXY8eyQYo.jpg",
        ]);

        $rest->kitchens()->attach([
            (Kitchen::where("name","Пицца")->first())->id,
            (Kitchen::where("name","Бургеры")->first())->id,
            (Kitchen::where("name","Американская")->first())->id,
            (Kitchen::where("name","Европейская")->first())->id,
        ]);

        array_push($tmp, $rest->id);

        $rest = Restoran::create([
            'name' => 'Суши-кафе "ISUSHI"',
            'description' => '',
            'adress' => 'Набережная 153а, Донецк',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+380 (71) 383-07-41",
            'inst_page' => "isushi_dn",
            'site' => "https://isushi-dn.ru",
            'telegram_channel' => "-1001401139179",
            'vk_page' => "https://vk.com/isushi_dn",
            'logo' => "https://sun2.48276.userapi.com/Ddlgt2V179IpXAGWGLmzBDfI9VAGVXNvP8bWqA/wmilNUVJe7A.jpg",
            'url' => "isushi",
            'rest_img' => "https://sun9-71.userapi.com/c855720/v855720573/19103f/aAMxvd5BHv4.jpg",
        ]);

        $rest->kitchens()->attach([
            (Kitchen::where("name","Японская")->first())->id,
        ]);

        array_push($tmp, $rest->id);

        foreach ($tmp as $restId) {
            $rate = Rating::create([
                'content_type' => \App\Enums\ContentTypeEnum::Restoran,
                'content_id' => $restId,
            ]);

            $rest = Restoran::find($restId);
            $rest->rating_id = $rate->id;
            $rest->save();
        }

    }
}
