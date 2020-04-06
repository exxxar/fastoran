<?php

use App\Parts\Models\Fastoran\MenuCategory;
use Illuminate\Database\Seeder;

class MenuCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
     /*   foreach (MenuCategory::all() as $category)
            $category->delete();*/

        MenuCategory::truncate();

        MenuCategory::create(["name"=>"#десерт"]);
        MenuCategory::create(["name"=>"#суп"]);
        MenuCategory::create(["name"=>"#овощи"]);
        MenuCategory::create(["name"=>"#кофе"]);
        MenuCategory::create(["name"=>"#чай"]);
        MenuCategory::create(["name"=>"#напитки"]);
        MenuCategory::create(["name"=>"#меню"]);
        MenuCategory::create(["name"=>"#перепелка"]);
        MenuCategory::create(["name"=>"#люля_кебаб"]);
        MenuCategory::create(["name"=>"#шашлык"]);
        MenuCategory::create(["name"=>"#сет"]);
        MenuCategory::create(["name"=>"#гарнир"]);
        MenuCategory::create(["name"=>"#мясо"]);
        MenuCategory::create(["name"=>"#рыба"]);
        MenuCategory::create(["name"=>"#морепродукты"]);
        MenuCategory::create(["name"=>"#рулька"]);
        MenuCategory::create(["name"=>"#снеки"]);
        MenuCategory::create(["name"=>"#паста"]);
        MenuCategory::create(["name"=>"#салат"]);
        MenuCategory::create(["name"=>"#закуска"]);
        MenuCategory::create(["name"=>"#пита"]);
        MenuCategory::create(["name"=>"#хачапури"]);
        MenuCategory::create(["name"=>"#курица"]);
        MenuCategory::create(["name"=>"#гамбургер"]);
        MenuCategory::create(["name"=>"#бургер"]);
        MenuCategory::create(["name"=>"#соусы"]);
        MenuCategory::create(["name"=>"#набор"]);
        MenuCategory::create(["name"=>"#пицца"]);
        MenuCategory::create(["name"=>"#ролл"]);
        MenuCategory::create(["name"=>"#пирог"]);
        MenuCategory::create(["name"=>"#тост"]);
        MenuCategory::create(["name"=>"#тяхан"]);
        MenuCategory::create(["name"=>"#добавки"]);
        MenuCategory::create(["name"=>"#омлет"]);
        MenuCategory::create(["name"=>"#сендвич"]);


    }
}
