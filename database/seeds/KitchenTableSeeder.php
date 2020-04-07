<?php

use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\KitchenInRestoran;
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
        /*//
        foreach (Kitchen::all() as $kitchen)
            $kitchen->delete();*/

        KitchenInRestoran::truncate();
        Kitchen::truncate();

        $tmp = [];

        array_push($tmp, (Kitchen::create([
            'name' => "Вегетарианская кухня",
            'img' => "https://fastoran.com/img/kit_pizza.jpg",
            'is_active' => true,
            'alt_description' => 'Вегетарианская кухня'
        ]))->id);


        array_push($tmp, (Kitchen::create([
            'name' => "Домашняя кухня",
            'img' => "https://fastoran.com/img/kit_burger.jpg",
            'is_active' => true,
            'alt_description' => 'Домашняя кухня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Высокая кухня",
            'img' => "https://fastoran.com/img/kit_dessert.jpg",
            'is_active' => true,
            'alt_description' => 'Высокая кухня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Блюда живого огня",
            'img' => "https://fastoran.com/img/kit_live.jpg",
            'is_active' => true,
            'alt_description' => 'Блюда живого огня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Европейская кухня",
            'img' => "https://fastoran.com/img/kit_europe.jpg",
            'is_active' => true,
            'alt_description' => 'Европейская кухня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Японская кухня",
            'img' => "https://fastoran.com/img/kit_japan.jpg",
            'is_active' => true,
            'alt_description' => 'Японская кухня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Русская кухня",
            'img' => "https://fastoran.com/img/kit_russian.jpg",
            'is_active' => true,
            'alt_description' => 'Русская кухня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Американская кухня",
            'img' => "https://fastoran.com/img/kit_caucas.jpg",
            'is_active' => true,
            'alt_description' => 'Американская кухня'
        ]))->id);

        array_push($tmp, (Kitchen::create([
            'name' => "Постная кухня",
            'img' => "https://fastoran.com/img/kit_autor.jpg",
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
