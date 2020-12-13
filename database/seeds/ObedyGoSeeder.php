<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ObedyGoSeeder extends Seeder
{
    public function getProductsData()
    {
        return \Illuminate\Support\Facades\Storage::get("data.json");
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = [
            [
                "title" => "Супы",
            ],
            [
                "title" => "Напитки",
            ]
            ,
            [
                "title" => "Десерты",
            ],
            [
                "title" => "Соусы",
            ]
        ];

        $products = (object)json_decode($this->getProductsData());

        Log::info(print_r($products->data,true));

        \App\ObedyGoCategory::truncate();
        \App\ObedyGoProduct::truncate();

        foreach ($categories as $category)
            \App\ObedyGoCategory::create([
                "title" => $category["title"]
            ]);


        foreach ($products->data as $product)

            \App\ObedyGoProduct::create([
                'title' => $product->title,
                'description' => $product->description ?? null,
                'day_index' => $product->day_index ?? null,
                'image' => $product->image ?? null,
                'price' => $product->price ?? 0,
                'weight' => $product->weight ?? 0,
                'category_id' => $product->category_id ?? null,
                'food_part_id' => $product->food_part_id ?? null,
                'positions' => $product->positions ?? [],
                'is_week' => $product->is_week ?? false,
                'addition' => $product->addition ?? false,
                'checked' => $product->checked ?? null,
                'disabled' => $product->disabled ?? null
            ]);
    }
}
