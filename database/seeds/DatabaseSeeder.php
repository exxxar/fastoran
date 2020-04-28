<?php

use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\Rating;
use App\Parts\Models\Fastoran\Restoran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        // $this->call(KitchenTableSeeder::class);
        //  $this->call(RestoransTableSeeder::class);
        //   $this->call(MenuCategoryTableSeeder::class);


        $tmp = [];

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
            Kitchen::where("name", "Русская кухня")->first()->id,
            Kitchen::where("name", "Европейская кухня")->first()->id,
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

        Schema::enableForeignKeyConstraints();
    }
}
