<?php

namespace App\Http\Controllers;

use App\Parts\Models\Fastoran\MenuCategory;
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

            $api = new Client;
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
                    'count' => 200
                ]);


                foreach ($response2["response"]["items"] as $item2) {
                    //echo $item2["description"]." ".$item2["price"]["text"]." ".$item2["thumb_photo"]." ".$item2["title"]."<br>";


                    //preg_match_all('|\d+|', $item2["description"], $matches);
                    preg_match_all('/(#\w+)/u', $item2["description"], $matches);

                    // $count = $matches[0][0] ?? 0;
                    //dd($matches);


                    $cat = count($matches[0])>0?$matches[0][0]:"#безкатегории";


                    $category = MenuCategory::where("name", $cat)->first();
                    if (is_null($category)) {
                        $category = MenuCategory::create([
                            "name" => $cat
                        ]);
                    }
                    $weight = 0;//count($matches[0])>=2?($matches[0][0] ?? 0):0;

                    //preg_match_all('|\d+|', $item2["price"]["text"], $matches);

                    $price = intval(str_replace([" "], "", $item2["price"]["text"]));//$matches[0][0] ?? 0;

                    $rest = Restoran::with(["categories"])->where("name", $item["title"])->first();

                    if (is_null($rest))
                        continue;

                    $product = RestMenu::create([
                        'food_name' => $item2["title"],
                        'food_remark' => $item2["description"],
                        'food_ext' => $weight ?? 0,
                        'food_price' => $price,
                        'rest_id' => $rest->id,
                        'food_category_id' => $category->id,
                        'food_img' => $item2["thumb_photo"],
                        'stop_list' => false,
                    ]);


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
