<?php

namespace App\Http\Controllers;

use Allanvb\LaravelSemysms\Facades\SemySMS;
use App\Parts\Models\Fastoran\Kitchen;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\OrderDetail;

use App\Parts\Models\Fastoran\RestMenu;
use App\Parts\Models\Fastoran\Restoran;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Telegram\Bot\Laravel\Facades\Telegram;

class RestController extends Controller
{
    //

    public function __construct()
    {

    }

    public function searchFood(Request $request)
    {
        $food_name = $request->get("food_name") ?? null;
        $rest_name = $request->get("rest_name") ?? null;

        $products = null;

        if (is_null($rest_name) && !is_null($food_name))
            $products = RestMenu::query()
                ->where('food_name', 'LIKE', "%{$food_name}%")->paginate(100);

        if (!is_null($rest_name)) {
            $rest = (Restoran::with(["menus"])->where('name', 'LIKE', "%{$rest_name}%")->first());
            $products = is_null($rest)?null:$rest->menus()->paginate(100) ;
        }

        if (is_null($products))
            $products = RestMenu::paginate(100);


        return view('product-list', compact('products'))
            ->with('i', ($request->get('page', 1) - 1) * 100);
    }

    public function getMainPage(Request $request)
    {

        $sliderIndex = random_int(1, 3);
        $random_menu = RestMenu::with(["restoran"])->get()
            ->shuffle()
            ->take(8)
            ->skip(0);

        $kitchens_count = Kitchen::all()->count();
        $restorans_count = Restoran::all()->count();
        $menus_count = RestMenu::all()->count();
        $user_count = User::all()->count();

        $categories = MenuCategory::with(["menus"])->get();
        $products = RestMenu::all();

        return view("main", compact("random_menu","categories"))
            ->with("sliderIndex", $sliderIndex)
            ->with("kitchens_count", $kitchens_count)
            ->with("restorans_count", $restorans_count)
            ->with("menus_count", $menus_count)
            ->with("user_count", $user_count)
            ->with("products", $products);


    }

    public function getAllMenu(Request $request)
    {
        $products = RestMenu::paginate(20);

        return view('product-list', compact('products'))
            ->with('i', ($request->get('page', 1) - 1) * 15);
    }

    public function getRestList(Request $request)
    {
        $restorans = Restoran::with(["kitchens", "menus"])
            ->where("moderation", true)
            ->get();

        if ($request->ajax())
            return response()
                ->json([
                    'restorans' => $restorans,
                    'kitchens' => Kitchen::where("is_active", 1)->get()
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

        return view("rest-list", compact("restorans", "kitchen"));
    }

    public function getRestByDomain(Request $request, $domain)
    {

        $restoran = Restoran::with(["kitchens", "categories", "categories.menus"])->where("url", $domain)
            ->first();

        $products = RestMenu::where("rest_id", $restoran->id)->paginate(50);

        if ($request->ajax())
            return response()
                ->json([
                    'restoran' => $restoran
                ]);

        return view("rest", compact("restoran", "products"))
            ->with('i', ($request->get('page', 1) - 1) * 50);
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
        $phone = $request->get("phone") ?? '';
        $email = $request->get("email") ?? '';
        $from = $request->get("from") ?? '';
        $message = $request->get("message") ?? '';

        Log::info("$phone $email $from $message");

        if ($request->ajax())
            return response()
                ->json([
                    "message" => "success",
                    "status" => 200
                ]);

        return redirect()
            ->back()
            ->with("message", "Сообщение отправлено!");

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
