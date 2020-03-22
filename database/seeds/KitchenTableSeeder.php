<?php

use App\Parts\Models\Fastoran\Kitchen;
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

        for ($i = 0; $i < 10; $i++)
            Kitchen::create([
                'name' => "Kitchen $i",
                'img' => "https://s.inyourpocket.com/gallery/176853.jpg",
                'view' => true,
                'alt_description' => 'test'
            ]);
    }
}
