<?php

use App\Parts\Models\Fastoran\Section;
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
        $this->call(BotTableSeeder::class);

        //$this->call(SectionTableSeeder::class);
        //$this->call(ObedyGoSeeder::class);
        //$this->call(OrderHubRuleTableSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}
