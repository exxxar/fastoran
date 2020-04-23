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
            Kitchen::where("name", "Русская кухня")->first()->id,
            Kitchen::where("name", "Европейская кухня")->first()->id,
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

        Schema::enableForeignKeyConstraints();
    }
}
