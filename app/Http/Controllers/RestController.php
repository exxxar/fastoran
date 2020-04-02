<?php

namespace App\Http\Controllers;

use Allanvb\LaravelSemysms\Facades\SemySMS;
use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\OrderDetail;

use App\Parts\Models\Fastoran\Restoran;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class RestController extends Controller
{
    //

    public function getMainPage(Request $request)
    {
       /* $kitchens = Kitchen::where("is_active", 1)
            ->get();

        $restorans = Restoran::where("moderation", true)
            ->take(12)
            ->skip(0)
            ->get();


        if ($request->ajax())
            return response()
                ->json([
                    'kitchens' => $kitchens,
                    'restorans' => $restorans
                ]);

        return view("main", compact("kitchens", "restorans"));*/

       return view("main");

    }

    public function getRestList(Request $request)
    {
        $restorans = Restoran::with([ "kitchens", "menus"])
            ->where("moderation", true)
            ->get();

        if ($request->ajax())
            return response()
                ->json([
                    'restorans' => $restorans,
                    'kitchens' => Kitchen::where("is_active",1)->get()
                ]);

        return view("rest-list", compact("restorans"));
    }

    public function getRestListByKitchen(Request $request, $kitchenId)
    {
        $kitchen = Kitchen::with(["restorans"])
            ->where("id", $kitchenId)
            ->first();


        $restorans = is_null($kitchen) ? null : $kitchen->restorans()->get();

        if ($request->ajax())
            return response()
                ->json([
                    'restorans' => $restorans
                ]);

        return view("rest-list", compact("restorans", "kitchenId"));
    }

    public function getRestByDomain(Request $request, $domain)
    {
        $restoran = Restoran::where("url", $domain)
            ->first();


        if ($request->ajax())
            return response()
                ->json([
                    'restoran' => $restoran
                ]);

        return view("rest", compact("restoran"));
    }

    public function getMenuByRestoran(Request $request, $id)
    {
        $restoran = Restoran::with(["menus"])
            ->where("id", $id)
            ->first();

        $categories = MenuCategory::all();


        return response()
            ->json([
                'restoran' => $restoran,
                "categories" => $categories
            ]);
    }





    public function sendWish(Request $request)
    {
        $phone = $request->get("phone");
        $email = $request->get("email");
        $from = $request->get("from");

        Log::info("$phone $email $from");

        return response()
            ->json([
                "message" => "success",
                "status" => 200
            ]);

    }

    public function sendRequest(Request $request)
    {
        $name = $request->get("name") ?? '';
        $phone = $request->get("phone") ?? '';
        $message = $request->get("message") ?? '';

        Telegram::sendMessage([
            'chat_id' => env("CHANNEL_ID"),
            'parse_mode' => 'Markdown',
            'text' => sprintf("*Заявка на обратный звонок*\n_%s_\n_%s_\n%s", $name, $phone, $message),
            'disable_notification' => 'false'
        ]);
    }


}
