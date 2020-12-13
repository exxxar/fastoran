<?php

namespace App\Http\Controllers\ObedyGo;

use App\Classes\Utilits;
use App\Events\SendSmsEvent;
use App\Http\Controllers\Controller;
use App\ObedyGoCategory;
use App\ObedyGoProduct;
use Illuminate\Http\Request;

class ObedyGoController extends Controller
{
    use Utilits;

    public function getProductList()
    {
        return response()->json(ObedyGoProduct::all());
    }

    public function getCategoryList()
    {
        return response()->json(ObedyGoCategory::all());
    }

    public function order(Request $request)
    {

        $request->validate([
            "phone" => "required",
            "name" => "required",
            "address" => "required",
            "products" => "required",
        ]);

        $phone = $this->preparePhone($request->get("phone") ?? $request->get("receiver_phone") ?? '+380710000012');

        $name = $request->get("name");
        $address = $request->get("address");
        $message = $request->get("message")??'';


        //$this->sendMessageToTelegramChannel(env("TELEGRAM_FASTORAN_ADMIN_CHANNEL"), $message_admin);
        //event(new SendSmsEvent($user->phone, "Ваш заказ #$order->id (fastoran.com) будет принят в обработку с 10:00!"));
    }
}
