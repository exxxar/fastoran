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
        foreach (MenuCategory::all() as $category)
            $category->delete();


    }
}
