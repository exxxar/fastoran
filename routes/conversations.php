<?php


use App\Conversations\MainConversation;
use App\Conversations\SuperadminConversation;
use Illuminate\Support\Facades\Log;




$this->ask("keyword_ask", MainConversation::class . "::keyword")
    ->where("/[a-zA-Z0-9]{1,10}/ui")
    ->fall(MainConversation::class . "::fallback",
        "Хм, а %s точно нужное ключевое слово?");

$this->ask("keyword_city", MainConversation::class . "::selectCity")
    ->where("/[а-яёА-ЯЁ ]{5,20}/ui")
    ->fall(MainConversation::class . "::fallback",
        "Город \"%s\" должно быть *на русском*!"
    );

$this->ask("decline_message", MainConversation::class . "::declineMessage")
    ->where("/[a-zA-Z0-9а-яА-Я ]{1,50}/ui")
    ->fall(MainConversation::class . "::fallback",
        "Хм, а %s точно правильная формулировка отказа?");

$this->ask("change_summary_price", SuperadminConversation::class . "::summaryPrice")
    ->where("/[0-9]{1,10}/ui")
    ->fall(MainConversation::class . "::fallback",
        "Хм, а %s точно адекватная цена заказа?");

$this->ask("change_delivery_price", SuperadminConversation::class . "::deliveryPrice")
    ->where("/[0-9]{1,10}/ui")
    ->fall(MainConversation::class . "::fallback",
        "Хм, а %s точно адекватная цена доставки?");


