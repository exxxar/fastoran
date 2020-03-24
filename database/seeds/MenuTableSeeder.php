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

        $tmp = [];
        for ($i = 0; $i < 10; $i++) {
            $cat = MenuCategory::create([
                'name' => "Категория $i",
                'rest_id' => 289,
                'business' => 1,
                'sort' => 1,
            ]);
            array_push($tmp, $cat->id);
        }

        foreach ($tmp as $t) {
            for ($i = 0; $i < 10; $i++)
                Menu::create([
                    'food_name' => "eда $i",
                    'food_remark' => "Описание еды $i",
                    'food_ext' => "250",
                    'food_price' => 200,
                    'food_rubr_id' => 0,
                    'food_razdel_id' => 0,
                    'rest_id' => 289,
                    'food_category_id' => $t,
                    'food_img' => "https://ru.vuejs.org/images/logo.png",
                    'bonus' => 0,
                    'stop_list' => 1,
                ]);
        }
    }
}
