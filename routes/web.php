<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Allanvb\LaravelSemysms\Facades\SemySMS;
use App\Parts\Models\Fastoran\RestMenu;
use App\Parts\Models\Fastoran\Restoran;
use App\Rating;
use ATehnix\VkClient\Auth as VkAuth;
use ATehnix\VkClient\Client;

Route::get('/', 'RestController@getMainPage');
Route::get('/rest/{domain}', 'RestController@getRestByDomain')->name("rest");
Route::get('/kitchen-list', 'RestController@getKitchenList')->name("kitchen-list");
Route::get('/rest-list', 'RestController@getRestList')->name("rest-list");
Route::get('/rest-list/kitchen/{id}', 'RestController@getRestListByKitchen')->name("kitchen");

Route::view("/about", "about")->name("about");
Route::view("/partner", "partner")->name("partner");
Route::view("/agreement", "agreement")->name("agreement");
Route::view("/questions", "questions")->name("questions");

Route::post('/save', 'ContentController@save')->name("test.save");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('admin')->group(function () {
    Route::view("/", "admin.main");
    Route::resources([
        'kitchens' => 'Fastoran\KitchenController',
        'menus' => 'Fastoran\MenuController',
        'regions' => 'Fastoran\RegionController',
        'menu_categories' => 'Fastoran\MenuCategoryController',
        'orders' => 'Fastoran\OrderController',
        'order_details' => 'Fastoran\OrderDetailController',
        'restorans' => 'Fastoran\RestoransController',
        'users' => 'UserController',
    ]);
});


Route::get('/vkontakte', function (\Illuminate\Http\Request $request) {
    $auth = new VkAuth('7384241', 'eNYSaEk3l2FuZzAePCnH', 'https://fastoran.com/vkontakte', 'market');


    $token = null;

    if ($request->has("code")) {
        $token = $auth->getToken($request->get('code'));

        $api = new Client;
        $api->setDefaultToken($token);

        $response = $api->request('market.getAlbums', [
            'owner_id' => -142695628,
            'count' => 50
        ]);


        RestMenu::truncate();
        //работает
        foreach ($response["response"]["items"] as $item) {
            //echo $item["id"].$item["title"]." ".$item["photo"]["photo_807"]."<br>";

            $response2 = $api->request('market.get', [
                'owner_id' => -142695628,
                'album_id' => $item["id"],
                'count' => 200
            ]);


            foreach ($response2["response"]["items"] as $item2) {
                //echo $item2["description"]." ".$item2["price"]["text"]." ".$item2["thumb_photo"]." ".$item2["title"]."<br>";


                preg_match_all('|\d+|', $item2["description"], $matches);

                $count = $matches[0][0] ?? 0;
                $weight = $matches[0][1] ?? 0;

                preg_match_all('|\d+|', $item2["price"]["text"], $matches);

                $price = $matches[0][0] ?? 0;

                $rest = Restoran::where("name", $item["title"])->first();

                if (is_null($rest))
                    continue;

                $product = RestMenu::create([
                    'food_name' => $item2["title"],
                    'food_remark' => $item2["description"],
                    'food_ext' => $weight ?? 0,
                    'food_price' => $price,
                    'rest_id' => $rest->id,
                    'food_category_id' => null,
                    'food_img' => $item2["thumb_photo"],
                    'stop_list' => false,
                ]);
            }

            $rate = Rating::create([
                'content_type' => \App\Enums\ContentTypeEnum::Menu,
                'content_id' => $product->id,
            ]);

            $product->rating_id = $rate->id;
            $product->save();

            sleep(2);

        }
        //dd($response["items"]);

    }

    return view('home', compact("auth", "token"));
});
