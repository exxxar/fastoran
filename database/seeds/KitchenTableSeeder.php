<?php

use App\Parts\Models\Fastoran\Kitchen;
use App\Rating;
use Illuminate\Database\Seeder;

class KitchenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        foreach (Kitchen::all() as $kitchen)
            $kitchen->delete();

        $tmp = [];

        array_push($tmp, (Kitchen::create([
            'name' => "Пицца",
            'img' => "img/kit_pizza.jpg",
            'is_active' => true,
            'alt_description' => 'Пицца'
        ]))->id);


        array_push($tmp, (Kitchen::create([
            'name' => "Бургеры",
            'img' => "img/kit_burger.jpg",
            'is_active' => true,
            'alt_description' => 'Бургеры'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Кондитерские",
            'img' => "img/kit_dessert.jpg",
            'is_active' => true,
            'alt_description' => 'Кондитерские'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Блюда живого огня",
            'img' => "img/kit_live.jpg",
            'is_active' => true,
            'alt_description' => 'Блюда живого огня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Европейская",
            'img' => "img/kit_europe.jpg",
            'is_active' => true,
            'alt_description' => 'Европейская кухня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Японская",
            'img' => "img/kit_japan.jpg",
            'is_active' => true,
            'alt_description' => 'Японская кухня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Русская",
            'img' => "img/kit_russian.jpg",
            'is_active' => true,
            'alt_description' => 'Русская кухня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Американская",
            'img' => "img/kit_caucas.jpg",
            'is_active' => true,
            'alt_description' => 'Американская кухня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Постная",
            'img' => "img/kit_autor.jpg",
            'is_active' => true,
            'alt_description' => 'Постная кухня'
        ]))->id);

        foreach ($tmp as $kitchenId) {
            $rate = Rating::create([
                'content_type' => \App\Enums\ContentTypeEnum::Kitchen,
                'content_id' => $kitchenId,
            ]);

            $kitchen = Kitchen::find($kitchenId);
            $kitchen->rating_id = $rate->id;
            $kitchen->save();
        }
    }
}
