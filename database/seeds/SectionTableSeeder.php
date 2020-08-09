<?php

use App\Parts\Models\Fastoran\Restoran;
use App\Parts\Models\Fastoran\RestoranInSection;
use App\Parts\Models\Fastoran\Section;
use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RestoranInSection::truncate();
        Section::truncate();

        $section = Section::create([
            'name' => "Рестораны",
            'img' => "/images/fastoran/sections/restorans.jpg",
            'is_active' => true,
            'alt_description' => ''
        ]);

        $section->restorans()->attach([
            Restoran::where("name", 'Ресторан "Diner"')->first()->id,
            Restoran::where("name", 'Суши-кафе "ISUSHI & PIZZA"')->first()->id,
            Restoran::where("name", 'Ресторан "Осетинские Пироги"')->first()->id,
            Restoran::where("name", 'ДонМак')->first()->id,
            Restoran::where("name", 'Пиццерия "Большой Джон"')->first()->id,
            Restoran::where("name", 'Ресторан "Аркадия"')->first()->id,
            Restoran::where("name", 'Оливье 80')->first()->id,
            Restoran::where("name", 'Лабиринт')->first()->id,
            Restoran::where("name", 'Шаурма на углях')->first()->id,
            Restoran::where("name", 'Челентано')->first()->id,
            Restoran::where("name", 'Golden Lion')->first()->id,
            Restoran::where("name", 'Гастро - паб "Свинья"')->first()->id,
            Restoran::where("name", 'Шаурмен')->first()->id,
        ]);


        $section = Section::create([
            'name' => "Продукты",
            'img' => "/images/fastoran/sections/products.jpg",
            'is_active' => true,
            'alt_description' => ''
        ]);

        $section->restorans()->attach([
            Restoran::where("name", 'Томатов')->first()->id,
            Restoran::where("name", 'Енакиевский мясокомбинат')->first()->id,
        ]);

        $section = Section::create([
            'name' => "Цветы",
            'img' => "/images/fastoran/sections/flowers.jpg",
            'is_active' => true,
            'alt_description' => ''
        ]);

        $section->restorans()->attach([
            Restoran::where("name", 'Доставка цветов')->first()->id,
        ]);


    }
}
