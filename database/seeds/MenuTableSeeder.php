<?php

use App\Parts\Models\Fastoran\Menu;
use App\Parts\Models\Fastoran\MenuCategory;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MenuCategory::create([
            'name'=>"Категория 1",
            'rest_id'=>1,
            'business'=>1,
            'sort'=>1,
        ]);

        Menu::create([
            'food_name',
            'food_remark',
            'food_ext',
            'food_price',
            'food_rubr_id',
            'food_razdel_id',
            'rest_id',
            'food_category_id',
            'food_img',
            'bonus',
            'stop_list',
        ]);
    }
}
