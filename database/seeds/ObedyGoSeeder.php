<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

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

        Log::info(print_r($products->data, true));

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

        $mpdf = new Mpdf();


        $mpdf->WriteHTML('<h1>Список кодов</h1>');

        \App\Lottery::truncate();
        \App\LotteryPromocode::truncate();

        $place_count = 40;
        \App\Lottery::create([
            'image' => '/img/go/lottery/lottery_1.png',
            'title' => 'Праздничная лотерея',
            'description' => "Пробная праздничная лотерея!",
            'occuped_places' => \GuzzleHttp\json_encode([]),
            'place_count' => $place_count,
            'free_place_count' => $place_count,
            'is_active' => true,
            'is_complete' => false,
            'date_end' => (new \Carbon\Carbon("+3:00"))->addMonths(5),
        ]);


        $tmp_codes = '';
        for ($i = 0; $i < $place_count; $i++) {
            $code = substr((string)Str::uuid(), 0, 16);
            \App\LotteryPromocode::create([
                'code' => $code,

            ]);

            $tmp_codes .= $code . ", ";

        }


        $mpdf->WriteHTML('<p>' . $tmp_codes . '</p>');

        $mpdf->Output('codes.pdf', Destination::FILE);


    }
}
