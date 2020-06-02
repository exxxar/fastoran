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
            'name' => 'Челентано',
            'description' => 'https://sun9-70.userapi.com/c857036/v857036007/13eea3/5ttvuSSqtOo.jpg',
            'adress' => 'г. Донецк, бульвар Пушкина, 24',
            'city' => 'Донецк',
            'region' => "Ворошиловский",
            'phone1' => "",
            'phone2' => "",
            'inst_page' => "chelentano_dn",
            'site' => "",
            'telegram_channel' => "-1001117924560",
            'vk_page' => "",
            'logo' => "https://sun9-39.userapi.com/c855528/v855528134/22db6a/3Lh6z7EP9N4.jpg",
            'url' => "chelentano_dn",
            'rest_img' => "https://fastoran.com/images/bg/18.jpg",
        ]);

        $rest->kitchens()->attach([
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
