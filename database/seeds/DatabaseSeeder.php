<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(KitchenTableSeeder::class);
        //$this->call(RestoransTableSeeder::class);
        $this->call(MenuTableSeeder::class);
    }
}
