<?php

use App\OrderHubRule;
use Illuminate\Database\Seeder;

class OrderHubRuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        OrderHubRule::truncate();
        OrderHubRule::create([
            'vk_user_id'=>"14054379",
            'rest_id'=>2,
            'rest_channel_id'=>"2000000008",
            'admin_channel_id'=>"2000000007",
            'delivery_channel_id'=>"2000000009",
            'phone'=>"+380714320661",
            'description'=>"Главный администратор",
            'is_admin'=>true,
            'is_deliveryman'=>true,
            'is_main_admin'=>true,
        ]);

/*
        [date] => 1610304061
    [from_id] => 14054379
    [id] => 226
    [out] => 0
    [peer_id] => 14054379
    [text] => Расчитать расстояние
    [conversation_message_id] => 169
    [fwd_messages] => Array*/
    }
}
