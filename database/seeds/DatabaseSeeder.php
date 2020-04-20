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
            'name' => 'Оливье 80',
            'description' => 'Ресторан семейных традиций "Оливье 80"',
            'adress' => 'проспект Гурова, 16, Донецк',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "+380714524586",
            'phone2' => "",
            'inst_page' => "olivie80",
            'site' => "",
            'telegram_channel' => "-1001498666636",
            'vk_page' => "https://vk.com/olivie80",
            'logo' => "https://sun9-41.userapi.com/c857728/v857728771/1c8b67/tH7W7gdbWrk.jpg",
            'url' => "olivie80",
            'rest_img' => "https://fastoran.com/images/bg/18.jpg",
        ]);

        $rest->kitchens()->attach([
            Kitchen::where("name", "Русская кухня")->first()->id,
            Kitchen::where("name", "Европейская кухня")->first()->id,
            Kitchen::where("name", "Вегетарианская кухня")->first()->id,
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
