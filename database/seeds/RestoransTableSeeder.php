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

        /* foreach (Restoran::all() as $restoran)
             $restoran->delete();*/

        Rating::truncate();
        Restoran::truncate();


        $tmp = [];

        $rest = Restoran::create([
            'name' => 'Ресторан "Diner"',
            'description' => 'Diner" - это заведение, пропитанное атмосферой Америки 40-50х годов. Новая гастрономическая концепция ресторана обусловлена приездом известного российского шеф-повара, который работал с лучшими рестораторами России. Бургеры, вок и пицца - это основные направления заведения.
🔍 Театральный проспект, 28
Время работы: уточняется',
            'adress' => 'Театральный проспект, 28, Донецк',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+38(071)07-888-70",
            'phone2' => "+38(071)50-777-05",
            'inst_page' => "diner_dn",
            'site' => "https://diner-dn.ru",
            'telegram_channel' => "-1001288545639",
            'vk_page' => "https://vk.com/diner_dn",
            'logo' => "https://sun9-7.userapi.com/c853628/v853628795/20a691/UyJKvjjioYs.jpg",
            'url' => "diner",
            'rest_img' => "https://fastoran.com/images/bg/18.jpg",
        ]);

        $rest->kitchens()->attach([
            Kitchen::where("name", "Американская кухня")->first()->id,
            Kitchen::where("name", "Европейская кухня")->first()->id,
            Kitchen::where("name", "Вегетарианская кухня")->first()->id,
        ]);




        array_push($tmp, $rest->id);

        $rest = Restoran::create([
            'name' => 'Суши-кафе "ISUSHI"',
            'description' => '«ISUSHI» - суши-кафе с большим ассортиментом уникальных авторских блюд и красивым дизайном. Новое, но уже полюбившееся, место, в котором каждый найдет для себя что-то свое.
🔍 г. Донецк, ул. Набережная, 153А
Время работы: 10:00-21:00
',
            'work_time' => "10:00-21:00",
            'adress' => 'Набережная 153а, Донецк',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+380 (71) 383-07-41",
            'inst_page' => "isushi_dn",
            'site' => "https://isushi-dn.ru",
            'telegram_channel' => "-1001353175622",
            'vk_page' => "https://vk.com/isushi_dn",
            'logo' => "https://sun9-25.userapi.com/c853628/v853628795/20a6b5/TsC0AOrG9B4.jpg",
            'url' => "isushi",
            'rest_img' => "https://fastoran.com/images/bg/23.jpg",
        ]);

        $rest->kitchens()->attach([
            Kitchen::where("name", "Японская кухня")->first()->id,
            Kitchen::where("name", "Постная кухня")->first()->id,
        ]);

        array_push($tmp, $rest->id);

        $rest = Restoran::create([
            'name' => 'Ресторан "Осетинские Пироги"',
            'description' => '«Пироги» - это самые вкусные осетинские пироги и великолепная грузинская кухня. Отличная альтернатива для тех, кто уже "пробовал все".
🔍 г. Донецк, Площадь Конституции, 1
Время работы: 10:00-21:00',
            'work_time' => "10:00-21:00",
            'adress' => 'пл.Конституции 1, Донецк',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+380 (71) 472-90-12",
            'phone2' => "",
            'inst_page' => "pirogi_dn",
            'site' => "",
            'telegram_channel' => "-1001318517801",
            'vk_page' => "https://vk.com/pirogi_dn",
            'logo' => "https://sun9-57.userapi.com/c853628/v853628795/20a6ac/9evk9dyjNRg.jpg",
            'url' => "pirogi_dn",
            'rest_img' => "https://fastoran.com/images/bg/20.jpg",
        ]);



        array_push($tmp, $rest->id);

        $rest = Restoran::create([
            'name' => 'ДонМак',
            'description' => 'Известная сеть быстрого питания, покорившая сердца многих. Фирменные рецепты картофеля фри, гамбургеров и чизбургеров, - этот вкус знаком каждому',
            'adress' => 'Бульвар Шевченко 6Б',
            'work_time' => "07:00-23:00",
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+38(071)385-16-28",
            'phone2' => "+38(071)385-16-27",
            'inst_page' => "donmak",
            'site' => "",
            'telegram_channel' => "-1001212017465",
            'vk_page' => "https://vk.com/donmak_dn",
            'logo' => "https://sun9-56.userapi.com/c855536/v855536185/211386/Xwj3NwAkhlA.jpg",
            'url' => "donmak_dn",
            'rest_img' => "https://fastoran.com/images/bg/19.jpg",
        ]);


        $rest->kitchens()->attach([
            Kitchen::where("name", "Американская кухня")->first()->id,
            Kitchen::where("name", "Европейская кухня")->first()->id,
        ]);


        array_push($tmp, $rest->id);


        $rest = Restoran::create([
            'name' => 'Пиццерия "Большой Джон"',
            'description' => 'Мы находимся в районе Крытого рынка, доставка охватывает близлежащие районы. Время работы - 11:00 - 21:00',
            'adress' => '50-річчя СРСР вулиця, 144/3, Донецк',
            'city' => 'Донецк',
            'work_time' => "11:00-21:00",
            'region' => "Ворошиловский",
            'phone1' => "+38 (071) 334 32 77",
            'phone2' => "+38 (050) 26 84 777",
            'inst_page' => "bolshoyjohn",
            'site' => "",
            'telegram_channel' => "-1001291305462",
            'vk_page' => "https://vk.com/bolshoyjohn",
            'logo' => "https://sun9-8.userapi.com/c853628/v853628795/20a69a/a-NFYnkkcFQ.jpg",
            'url' => "bolshoyjohn",
            'rest_img' => "https://fastoran.com/images/bg/18.jpg",
        ]);


        $rest->kitchens()->attach([
            Kitchen::where("name", "Американская кухня")->first()->id,
            Kitchen::where("name", "Европейская кухня")->first()->id,
        ]);


        array_push($tmp, $rest->id);

        $rest = Restoran::create([
            'name' => 'Ресторан "Аркадия"',
            'description' => 'Ресторан, который жарит вкусно. Слоган говорит сам за себя. Ну а уникальные акции и специальные предложения являются приятным бонусом к прекрасному пейзажу и качественному обслуживанию.',
            'adress' => 'г. Донецк, ул. Набережная, 153А',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+38 (071) 489-28-23",
            'phone2' => "",
            'inst_page' => "arkadia_donetsk",
            'site' => "",
            'telegram_channel' => "-1001286334872",
            'vk_page' => "https://vk.com/arkadia_donetsk",
            'logo' => "https://sun9-52.userapi.com/c853628/v853628795/20a688/44t05KqRsMM.jpg",
            'url' => "arkadia_donetsk",
            'rest_img' => "https://fastoran.com/images/bg/18.jpg",
        ]);


        $rest->kitchens()->attach([
            Kitchen::where("name", "Блюда живого огня")->first()->id,
            Kitchen::where("name", "Американская кухня")->first()->id,
            Kitchen::where("name", "Европейская кухня")->first()->id,
            Kitchen::where("name", "Вегетарианская кухня")->first()->id,
            Kitchen::where("name", "Домашняя кухня")->first()->id,
            Kitchen::where("name", "Японская кухня")->first()->id,
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
