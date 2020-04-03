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
            'logo' => "https://sun9-7.userapi.com/c853628/v853628795/20a691/UyJKvjjioYs.jpg",
            'url' => "diner",
            'rest_img' => "https://sun9-7.userapi.com/c853628/v853628795/20a691/UyJKvjjioYs.jpg",
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
            'logo' => "https://sun9-25.userapi.com/c853628/v853628795/20a6b5/TsC0AOrG9B4.jpg",
            'url' => "isushi",
            'rest_img' => "https://sun9-71.userapi.com/c855720/v855720573/19103f/aAMxvd5BHv4.jpg",
        ]);

        $rest->kitchens()->attach([
            (Kitchen::where("name","Японская")->first())->id,
        ]);

        array_push($tmp, $rest->id);

        $rest = Restoran::create([
            'name' => 'Ресторан "Осетинские Пироги"',
            'description' => '',
            'adress' => 'пл.Конституции 1, Донецк',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+380 (71) 472-90-12",
            'phone2' => "",
            'inst_page' => "pirogi_dn",
            'site' => "",
            'telegram_channel' => "-1001401139179",
            'vk_page' => "https://vk.com/pirogi_dn",
            'logo' => "https://sun9-57.userapi.com/c853628/v853628795/20a6ac/9evk9dyjNRg.jpg",
            'url' => "pirogi_dn",
            'rest_img' => "https://sun9-57.userapi.com/c853628/v853628795/20a6ac/9evk9dyjNRg.jpg",
        ]);

        $rest->kitchens()->attach([
            (Kitchen::where("name","Русская")->first())->id,
            (Kitchen::where("name","Американская")->first())->id,
            (Kitchen::where("name","Европейская")->first())->id,
        ]);

        array_push($tmp, $rest->id);

        $rest = Restoran::create([
            'name' => 'ДонМак',
            'description' => 'известная сеть быстрого питания, покорившая сердца многих. Фирменные рецепты картофеля фри, гамбургеров и чизбургеров, - этот вкус знаком каждому',
            'adress' => 'Проспект Ильича, 1/119',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+380 (71) 472-90-12",
            'phone2' => "",
            'inst_page' => "donmak",
            'site' => "",
            'telegram_channel' => "-1001401139179",
            'vk_page' => "https://vk.com/donmak",
            'logo' => "https://sun9-8.userapi.com/c853628/v853628795/20a69a/a-NFYnkkcFQ.jpg",
            'url' => "pirogi_dn",
            'rest_img' => "https://sun9-8.userapi.com/c853628/v853628795/20a69a/a-NFYnkkcFQ.jpg",
        ]);

        $rest->kitchens()->attach([
            (Kitchen::where("name","Бургеры")->first())->id,
            (Kitchen::where("name","Американская")->first())->id,
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
