<?php

namespace App\Http\Controllers\ObedyGo;

use App\Events\LotteryEvent;
use App\Events\SendSmsEvent;
use App\Http\Controllers\Controller;
use App\Lottery;
use App\LotteryPromocode;
use App\Mail\LotteryMail;
use App\Mail\ReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LotteryController extends Controller
{

    public function getLotteryList()
    {
        return response()->json(Lottery::where("is_active", true)
            ->where("is_complete", false)
            ->get());
    }

    public function getLottery($id)
    {
        return response()->json(Lottery::where("id", $id)->first());
    }

    public function pickPlace(Request $request)
    {
        $request->validate([
            "code" => "required",
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "lottery_id" => "required",
            "index" => "required"
        ]);

        $promocode = LotteryPromocode::where("code", $request->get("code"))
            ->where("is_activated", false)
            ->first();

        if (is_null($promocode))
            return response()->json(["message" => "Данный Код не найден!"], 404);
        $lotteryId = $request->get("lottery_id");

        $lottery = Lottery::where("id", $lotteryId)
            ->where("is_active", true)
            ->where("is_complete", false)
            ->where("free_place_count", ">", 0)
            ->where("place_count", ">", 0)
            ->first();

        if (is_null($lottery))
            return response()->json(["message" => "Лотерея не найдена"], 404);

        $index = $request->get("index");

        $tmp_occuped_places = count(json_decode($lottery->occuped_places)) === 0 ? [] : json_decode($lottery->occuped_places);


        if (in_array($index, $tmp_occuped_places))
            return response()->json(["message" => "Данное поле уже занято"], 404);

        array_push($tmp_occuped_places, $index);


        $lottery->occuped_places = json_encode($tmp_occuped_places);

        $lottery->free_place_count -= 1;

        $lottery->save();

        $promocode->name = $request->get("name");
        $promocode->phone = $request->get("phone");
        $promocode->email = $request->get("email")??'';
        $promocode->is_activated = true;
        $promocode->lottery_id = $lotteryId;
        $promocode->save();

        $message =  sprintf("Вы заняли #%s место в розыгрше %s",
            $index,
            $lottery->title
        );

        event(new SendSmsEvent($promocode->phone,
               $message
            )
        );

        Mail::to( $promocode->email)
            ->send(new LotteryMail($message));


        if ($lottery->free_place_count == 0) {
            $place = LotteryPromocode::where("lottery_id", $lottery->id)
                ->get()
                ->random(1)
                ->first();

            $lottery->win_promo_id = $place->id;
            $lottery->is_active = false;
            $lottery->is_complete = true;
            $lottery->save();


            $message =  sprintf("Ваш #%s в розыгрыше %s оказался выигрышным! За деталями обратитесь к администратору сервиса.",
                $index,
                $lottery->title
            );

            event(new SendSmsEvent($promocode->phone,
                    $message
                )
            );

            Mail::to( $promocode->email)
                ->send(new LotteryMail($message));


        }


        event(new LotteryEvent($promocode->lottery_id));

        return response()->json(["message" => "Промокод успешно активирован!"]);


    }

}
