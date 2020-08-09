<?php

use App\Parts\Models\Fastoran\Section;
use App\Parts\Models\Fastoran\Rating;
use App\Parts\Models\Fastoran\Restoran;
use Illuminate\Database\Seeder;

class RestoransTableSeeder extends Seeder
{
    use \App\Classes\Utilits;
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
            Section::where("name", "Американская кухня")->first()->id,
            Section::where("name", "Европейская кухня")->first()->id,
            Section::where("name", "Вегетарианская кухня")->first()->id,
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
            Section::where("name", "Японская кухня")->first()->id,
            Section::where("name", "Постная кухня")->first()->id,
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
            Section::where("name", "Американская кухня")->first()->id,
            Section::where("name", "Европейская кухня")->first()->id,
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
            Section::where("name", "Американская кухня")->first()->id,
            Section::where("name", "Европейская кухня")->first()->id,
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
            Section::where("name", "Блюда живого огня")->first()->id,
            Section::where("name", "Американская кухня")->first()->id,
            Section::where("name", "Европейская кухня")->first()->id,
            Section::where("name", "Вегетарианская кухня")->first()->id,
            Section::where("name", "Домашняя кухня")->first()->id,
            Section::where("name", "Японская кухня")->first()->id,
        ]);


        array_push($tmp, $rest->id);

        $rest = Restoran::create([
            'name' => 'ЕшьБургер',
            'description' => 'Ешь-Бургер | Ешька | Донецк | Доставка',
            'adress' => 'г. Донецк, пл. Коммунаров, 2',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+38 (071) 347-04-94",
            'phone2' => "",
            'inst_page' => "eshburgers",
            'site' => "",
            'telegram_channel' => "-1001315174223",
            'vk_page' => "https://vk.com/eshburgers",
            'logo' => "https://sun9-37.userapi.com/c855020/v855020400/21c796/0l34obhy_zA.jpg",
            'url' => "eshburgers",
            'rest_img' => "https://fastoran.com/images/bg/18.jpg",
        ]);


        $rest->kitchens()->attach([
            Section::where("name", "Блюда живого огня")->first()->id,
            Section::where("name", "Американская кухня")->first()->id,
            Section::where("name", "Европейская кухня")->first()->id,
            Section::where("name", "Вегетарианская кухня")->first()->id,
            Section::where("name", "Домашняя кухня")->first()->id,
        ]);


        array_push($tmp, $rest->id);


        $rest = Restoran::create([
            'name' => 'Оливье 80',
            'description' => 'Ресторан семейных традиций "Оливье 80"',
            'adress' => 'Украина, г. Донецк, пр. Гурова, 16',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+380714524586",
            'phone2' => "",
            'inst_page' => "olivie80",
            'site' => "",
            'work_time'=>'11:00-19:45',
            'telegram_channel' => "-1001498666636",
            'vk_page' => "https://vk.com/olivie80",
            'logo' => "https://sun9-41.userapi.com/c857728/v857728771/1c8b67/tH7W7gdbWrk.jpg",
            'url' => "olivie80",
            'rest_img' => "https://fastoran.com/images/bg/18.jpg",
        ]);

        $rest->kitchens()->attach([
            Section::where("name", "Русская кухня")->first()->id,
            Section::where("name", "Европейская кухня")->first()->id,
            Section::where("name", "Вегетарианская кухня")->first()->id,
        ]);

        array_push($tmp, $rest->id);

     /*   $rest = Restoran::create([
            'name' => 'Дача',
            'description' => '"Дача"- самый "вкусный" караоке- клуб в Донецке. Место встречи для настоящих и будущих друзей.',
            'adress' => 'Украина, г. Донецк, ул. Артема, 92',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+380716518001",
            'phone2' => "",
            'inst_page' => "dacha_vertu",
            'site' => "",
            'telegram_channel' => "-1001447555333",
            'vk_page' => "https://vk.com/dacha_vertu",
            'logo' => "https://sun9-68.userapi.com/c855720/v855720553/22a96a/6bC0bN414G0.jpg",
            'url' => "dacha_vertu",
            'rest_img' => "https://fastoran.com/images/bg/18.jpg",
        ]);

        $rest->kitchens()->attach([
            Section::where("name", "Русская кухня")->first()->id,
            Section::where("name", "Европейская кухня")->first()->id,
            Section::where("name", "Японская кухня")->first()->id,
        ]);*/

/*
        array_push($tmp, $rest->id);*/

        $rest = Restoran::create([
            'name' => 'Лабиринт',
            'description' => 'После утомляющей рабочей недели так хочется увидеться и пообщаться с друзьями или провести вечер в романтической обстановке с любимым человеком. Можно, конечно, отправиться в театр, кинотеатр, сходить на концерт или в парк, но лучшим решением в данной ситуации будет отправиться в уютное кафе "Лабиринт" в Донецке.

Атмосфера кафе Лабиринт располагает гостей к приятному и спокойному времяпрепровождению за обедом или деловыми переговорами.

Это классическое кафе с украинской и русской кухнями.

К услугам гостей кафе "Лабиринт" качественная кухня, профессиональное обслуживание, комфортабельный интерьер. Летняя площадка, изысканные чебуреки, комплексные обеды.',
            'adress' => 'Украина, ул. Артёма д. 43, Донецк',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+380713460709",
            'phone2' => "",
            'inst_page' => "labirint_dn",
            'site' => "",
            'telegram_channel' => "-1001270989375",
            'vk_page' => "https://vk.com/club54853297",
            'logo' => "https://sun9-39.userapi.com/c855528/v855528134/22db6a/3Lh6z7EP9N4.jpg",
            'url' => "labirint_dn",
            'rest_img' => "https://fastoran.com/images/bg/18.jpg",
        ]);

        $rest->kitchens()->attach([
            Section::where("name", "Русская кухня")->first()->id,
            Section::where("name", "Европейская кухня")->first()->id,
        ]);


        array_push($tmp, $rest->id);

        $rest = Restoran::create([
            'name' => 'Шаурма на углях',
            'description' => '',
            'adress' => 'г. Донецк, ул. Кобозева, 48а',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "",
            'phone2' => "",
            'inst_page' => "shaurma_dn",
            'site' => "",
            'telegram_channel' => "-1001268258388",
            'vk_page' => "",
            'logo' => "https://sun9-39.userapi.com/c855528/v855528134/22db6a/3Lh6z7EP9N4.jpg",
            'url' => "shaurma_dn",
            'rest_img' => "https://fastoran.com/images/bg/18.jpg",
        ]);

        $rest->kitchens()->attach([
            Section::where("name", "Русская кухня")->first()->id,
            Section::where("name", "Европейская кухня")->first()->id,
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
