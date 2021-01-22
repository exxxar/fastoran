<?php

use Illuminate\Database\Seeder;

class BotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        \App\Bot::truncate();

        \App\Bot::create([
            'bot_url'=>"delivery_fastoran_bot",
            'token_prod'=>"1010474333:AAHPLSlhAiPh1kDaZvgKAwKYjf3E-9JELvA",
            'token_dev'=>"1010474333:AAHPLSlhAiPh1kDaZvgKAwKYjf3E-9JELvA",
            'description'=>"Бот доставки Фасторан",
            'bot_pic'=>"",
            'is_active'=>true,
            'money'=>310,
            'money_per_day'=>10,
        ]);
    }
}
