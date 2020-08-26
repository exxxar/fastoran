<?php

namespace App\Http\Controllers;

use App\Classes\Utilits;
use App\Enums\FoodStatusEnum;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\Promotion;
use App\Parts\Models\Fastoran\RestMenu;
use App\Parts\Models\Fastoran\Restoran;
use App\Parts\Models\Fastoran\Rating;
use App\Parts\Models\Fastoran\RestoranInCategory;
use ATehnix\VkClient\Auth;
use ATehnix\VkClient\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{

    use Utilits;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function uploadVk(Request $request)
    {
        $auth = new Auth('7384241', 'eNYSaEk3l2FuZzAePCnH', 'https://fastoran.com/vkontakte', 'market');


        Schema::disableForeignKeyConstraints();
        MenuCategory::truncate();
        RestoranInCategory::truncate();
        Schema::enableForeignKeyConstraints();

        $token = null;

        if ($request->has("code")) {
            $token = $auth->getToken($request->get('code'));

            $api = new Client('5.131');
            $api->setDefaultToken($token);

            $response = $api->request('market.getAlbums', [
                'owner_id' => -136275935,
                'count' => 50
            ]);

            RestMenu::truncate();
            //работает
            foreach ($response["response"]["items"] as $item) {
                //echo $item["id"].$item["title"]." ".$item["photo"]["photo_807"]."<br>";

                $response2 = $api->request('market.get', [
                    'owner_id' => -136275935,
                    'album_id' => $item["id"],
                    'count' => 200,
                ]);


                foreach ($response2["response"]["items"] as $item2) {
                    //echo $item2["description"]." ".$item2["price"]["text"]." ".$item2["thumb_photo"]." ".$item2["title"]."<br>";


                    //preg_match_all('|\d+|', $item2["description"], $matches);
                    preg_match_all('/(#\w+)/u', $item2["description"], $matches);

                    // $count = $matches[0][0] ?? 0;
                    //dd($matches);


                    $cat = count($matches[0]) > 0 ? $matches[0][0] : "#безкатегории";


                    $category = MenuCategory::where("name", $cat)->first();
                    if (is_null($category)) {
                        $category = MenuCategory::create([
                            "name" => $cat
                        ]);
                    }


                    //preg_match_all('|\d+|', $item2["price"]["text"], $matches);

                    $price = intval($item2["price"]["amount"]) / 100;//$matches[0][0] ?? 0;
                    $tmp_old_price = isset($item2["price"]["old_amount"]) ? intval($item2["price"]["old_amount"]) / 100 : 0;


                    $rest = Restoran::with(["categories"])->where("name", $item["title"])->first();

                    if (is_null($rest))
                        continue;


                    $description = $item2["description"];

                    preg_match_all('/([0-9]+).грамм/i', $description, $media);

                    $weight = count($matches) >= 2 ? ($media[1][0] ?? 0) : 0;

                    $food_status = [
                        "Акция!" => FoodStatusEnum::Promotion,
                        "Скидка!" => FoodStatusEnum::Promotion,
                        "Топ!" => FoodStatusEnum::InTheTop,
                        "Хит продаж!" => FoodStatusEnum::BestSeller,
                        "Новинка!" => FoodStatusEnum::NewFood,
                        "На вес!" => FoodStatusEnum::WeightFood,
                    ];

                    $food_status_index = null;

                    foreach ($food_status as $key => $status)
                        if (mb_strpos(mb_strtolower($description), mb_strtolower($key)))
                            $food_status_index = $key;

                  /*  if (!is_null($food_status_index))
                        if ($food_status[$food_status_index] === FoodStatusEnum::Promotion) {
                            Log::info("OLD PRICE=$tmp_old_price   " . print_r($item2, true));
                        }*/

                    $product = RestMenu::create([
                        'food_name' => $item2["title"],
                        'food_remark' => $description,
                        'food_ext' => $weight ?? 0,
                        'food_sub' => $this->prepareSub($description),
                        'food_price' => $price  ,
                        'food_discount_price' => $tmp_old_price ,
                        'food_status' => is_null($food_status_index) ? FoodStatusEnum::Unset : $food_status[$food_status_index],
                        'rest_id' => $rest->id,
                        'food_category_id' => $category->id,
                        'food_img' => $item2["thumb_photo"],
                        'stop_list' => false,
                    ]);

                    if (!is_null($food_status_index))
                        if ($food_status[$food_status_index] === FoodStatusEnum::Promotion) {
                            $promotion = Promotion::where('product->food_name', $product->food_name)
                                ->where('product->rest_id', $product->rest_id)
                                ->first();

                            if (is_null($promotion))
                                Promotion::create([
                                    'product' => $product
                                ]);
                        }


                    if (is_null($rest->categories()->find($category->id)))
                        RestoranInCategory::create([
                            'category_id' => $category->id,
                            'restoran_id' => $rest->id
                        ]);


                    $rate = Rating::create([
                        'content_type' => \App\Enums\ContentTypeEnum::Menu,
                        'content_id' => $product->id,
                    ]);

                    $product->rating_id = $rate->id;
                    $product->save();
                }


                sleep(2);

            }
            //dd($response["items"]);

        }

        return view('home', compact("auth", "token"));
    }
}
