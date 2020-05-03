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
use App\Enums\UserTypeEnum;
use App\Http\Controllers\Fastoran\MenuCategoryController;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\OrderDetail;
use App\Parts\Models\Fastoran\RestMenu;
use App\Parts\Models\Fastoran\Restoran;
use App\User;
use ATehnix\VkClient\Auth as VkAuth;
use ATehnix\VkClient\Client;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Jenssegers\Agent\Facades\Agent;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get("/desktop", "RestController@desktop")->name("mobile.desktop");

Route::prefix('m')->group(function () {
    Route::get("/", "RestController@mobile")->name("mobile.index");
    Route::view("/restorans", "mobile.pages.restorans")->name("mobile.restorans");
    Route::get("/restoran/{domain}", "Fastoran\\RestoransController@show")->name("mobile.restoran");
    Route::view("/profile", "mobile.pages.restorans")->name("mobile.profile");
    Route::view("/promotions", "mobile.pages.restorans")->name("mobile.promotions");
    Route::view("/cart", "mobile.pages.cart")->name("mobile.cart");
    Route::view("/status", "mobile.pages.status")->name("mobile.status");
    Route::get("/category/{id}", 'Fastoran\\MenuCategoryController@show')->name("mobile.category");
});


Route::get('/', 'RestController@getMainPage')->name("main");
Route::any('/search', 'RestController@searchFood')->name("search");

Route::get('/rest/{domain}', 'RestController@getRestByDomain')->name("rest");
Route::get('/all-menu', 'RestController@getAllMenu')->name("all.menu");


Route::get('/kitchen-list', 'RestController@getKitchenList')->name("kitchen-list");
Route::get('/rest-list', 'RestController@getRestList')->name("rest-list");
Route::get('/rest-list/kitchen/{id}', 'RestController@getRestListByKitchen')->name("kitchen");

Route::view('/cart', "fastoran.cart")->name("cart");
Route::view('/checkout', "fastoran.checkout")->name("checkout");

Route::view("/faq", "fastoran.faq")->name("faq");
Route::view("/custom-order", "fastoran.custom-order")->name("custom-order");
Route::view("/deliveryman-quest", "fastoran.deliveryman-quest")->name("deliveryman-quest");
Route::view("/about", "fastoran.about")->name("about");
Route::view("/partner", "fastoran.partner")->name("partner");
Route::view("/contacts", "fastoran.contacts")->name("contacts");
Route::view("/success", "fastoran.success")->name("success");
Route::view("/questions", "fastoran.questions")->name("questions");
Route::view("/agreement", "fastoran.agreement")->name("agreement");
Route::view("/terms-of-user", "fastoran.terms-of-use")->name("terms");
Route::view("/simple", "fastoran.simple-order")->name("simple");

Auth::routes(['register' => false]);

Route::get('/profile', 'Fastoran\\OrderController@getOrderHistory')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vkontakte', "HomeController@uploadVk");


Route::prefix('admin')->group(function () {
    Route::any("/", 'Admin\AdminController@index')->name("admin.main");
    Route::get('/vkontakte', "Admin\AdminController@uploadVk");
    Route::post('/uploadPhones', "Admin\AdminController@uploadPhones");
    Route::post('/sendMessage', "Admin\AdminController@sendMessage");
    Route::any("/statistics", 'Admin\AdminController@statistics')->name("admin.statistics");
    Route::get('/getStatistics', "Admin\AdminController@getStatistics");
    Route::get('/getOrdersByDate/{startDate}/{endDate}', "Admin\AdminController@getOrdersByDate");
    Route::get('/downloadStatistics', "Admin\AdminController@downloadStatistics");
    Route::get('/getRestoransStatistics/{startDate}/{endDate}', "Admin\AdminController@getRestoransStatistics");

    Route::any('/kitchens', 'Admin\KitchenController@index');
    Route::get('/kitchens/get', 'Admin\KitchenController@get');
    Route::post('/kitchens/store', 'Admin\KitchenController@store');
    Route::put('/kitchens/update/{id}', 'Admin\KitchenController@update');
    Route::delete('/kitchens/destroy/{id}', 'Admin\KitchenController@destroy');
    Route::post('/kitchens/restore/{id}', 'Admin\KitchenController@restore');
    Route::any('/kitchens/menu/{kitchenId}', 'Admin\KitchenController@getMenuByKitchenId');

    Route::any('/menus', 'Admin\MenuController@index');
    Route::get('/menus/get', 'Admin\MenuController@get');
    Route::post('/menus/store', 'Admin\MenuController@store');
    Route::get('/menus/show/{id}', 'Admin\MenuController@show');
    Route::put('/menus/update/{id}', 'Admin\MenuController@update');
    Route::delete('/menus/destroy/{id}', 'Admin\MenuController@destroy');
    Route::post('/menus/restore/{id}', 'Admin\MenuController@restore');
    Route::get('/menus/getMenuByRestId/{id}', 'Admin\MenuController@getMenuByRestId');

    Route::any('/menu_categories', 'Admin\MenuCategoryController@index');
    Route::get('/menu_categories/get', 'Admin\MenuCategoryController@get');
    Route::post('/menu_categories/store', 'Admin\MenuCategoryController@store');
    Route::put('/menu_categories/update/{id}', 'Admin\MenuCategoryController@update');
    Route::delete('/menu_categories/destroy/{id}', 'Admin\MenuCategoryController@destroy');
    Route::post('/menu_categories/restore/{id}', 'Admin\MenuCategoryController@restore');

    Route::any('/restorans', 'Admin\RestoransController@index');
    Route::get('/restorans/get', 'Admin\RestoransController@get');
    Route::post('/restorans/store', 'Admin\RestoransController@store');
    Route::put('/restorans/update/{id}', 'Admin\RestoransController@update');
    Route::delete('/restorans/destroy/{id}', 'Admin\RestoransController@destroy');
    Route::post('/restorans/restore/{id}', 'Admin\RestoransController@restore');
    Route::any('/restorans/menu/{restId}', 'Admin\MenuController@getMenuByRestId');
    Route::any('/restorans/kitchen/{kitchenId}', 'Admin\RestoransController@getRestoransByKitchenId');
    Route::post('/restorans/upload', 'Admin\RestoransController@uploadFile');
    Route::get('/restorans/stop-list/{id}', 'Admin\RestoransController@stoplist');
    Route::get('/restorans/getRestorans', 'Admin\RestoransController@getRestorans');


    Route::any('/orders', 'Admin\OrderController@index');
    Route::get('/orders/get', 'Admin\OrderController@get');
    Route::post('/orders/store', 'Admin\OrderController@store');
    Route::put('/orders/update/{id}', 'Admin\OrderController@update');
    Route::delete('/orders/destroy/{id}', 'Admin\OrderController@destroy');
    Route::post('/orders/restore/{id}', 'Admin\OrderController@restore');
    Route::any('/history', 'Admin\OrderController@getOrderHistory');
    Route::get('/orders/getDetails/{id}', 'Admin\OrderController@getDetails');
    Route::get('/orders/create', 'Admin\OrderController@create');
    Route::post('/orders/range/{restId}', 'Admin\OrderController@getRange');


    Route::any('/order_details', 'Admin\OrderDetailController@index');
    Route::get('/order_details/get', 'Admin\OrderDetailController@get');
    Route::post('/order_details/store', 'Admin\OrderDetailController@store');
    Route::put('/order_details/update/{id}', 'Admin\OrderDetailController@update');
    Route::delete('/order_details/destroy/{id}', 'Admin\OrderDetailController@destroy');
    Route::post('/order_details/restore/{id}', 'Admin\OrderDetailController@restore');


    Route::any('/users', 'Admin\UserController@index');
    Route::get('/users/get', 'Admin\UserController@get');
//    Route::post('/users/changePassword', 'Admin\UserController@changePassword');
    Route::post('/users/sendAuthCode', 'Admin\UserController@sendAuthCode');
    Route::get('/users/getPhones', 'Admin\UserController@getPhones');
    Route::put('/users/update/{id}', 'Admin\UserController@update');
    Route::delete('/users/destroy/{id}', 'Admin\UserController@destroy');
    Route::post('/users/restore/{id}', 'Admin\UserController@restore');
});


Route::get("/test_order", 'Fastoran\OrderController@testOrder');
Route::get("/test_login", function () {
    $query = json_encode([
        "phone" => "+380713189958",
        "password" => "491474",
        "remember_me:" => 1
    ]);

    try {
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/json' . PHP_EOL . 'X-Requested-With:XMLHttpRequest',
                'content' => $query
            ),
        ));

        ini_set('max_execution_time', 1000000);
        $content = file_get_contents(
            $file = 'https://fastoran.com/api/v1/auth/login_phone',
            $use_include_path = false,
            $context);
        ini_set('max_execution_time', 60);


    } catch (ErrorException $e) {
        $content = [];
    }


    dd(json_decode($content));
});
Route::get("/test_geo", function () {
    $data = YaGeo::setQuery('Донецк, ул. Артема')->load();
    $data = $data->getResponse()->getLatitude();
    dd($data);

});
Route::get("/test_deliveryman", function () {
    $orders = Order::with(["details", "restoran", "details.product", "user"])
        ->where("deliveryman_id", 5)
        ->get();

    dd($orders);
});

Route::get("/test_sms", function () {
    for ($i = 0; $i < 20; $i++)
        SemySMS::sendOne([
            'to' => '+380714320661',
            'text' => 'HELLO MY FRIENDS',
            'device_id' => 'active'
        ]);
});


Route::get("/test_getdata", function () {
    $orders = Order::with(["deliveryman", "restoran"])->whereDate('created_at', Carbon::today()->toDateString())
        //->whereNotNull("deliveryman_id")
        //->where("status",\App\Enums\OrderStatusEnum::Delivered)
        ->get();

    /*   $tmp_sum = [
            ["id"=>0,"range_count"=>0,"price"]
       ];*/


    $tmp = "";
    foreach ($orders as $order) {
        $tmp .= sprintf("Order:%s;#%s;%s руб.;%s км;%s;%s;%s;%s;\n\n",
            $order->id,
            $order->deliveryman_id,
            $order->delivery_price,
            $order->delivery_range,
            $order->restoran->name ?? '',
            $order->deliveryman->name ?? '',
            $order->receiver_address,
            $order->receiver_order_note

        );
    }

    Storage::put('file.txt', $tmp);
});

Route::get("/test_geo_2", function () {
    function calculateTheDistance($fA, $lA, $fB, $lB)
    {
        try {
            $content = file_get_contents("http://www.yournavigation.org/api/1.0/gosmore.php?flat=$fA&flon=$lA&tlat=$fB&tlon=$lB&v=motorcar&fast=1&layer=mapnik&format=geojson");


        } catch (\Exception $e) {
            $content = [];
        }

        return floatval(json_decode($content)->properties->distance ?? 0);
    }

    dd(calculateTheDistance('48.006619', '37.809605', '47.977030', '37.871176'));
});


Route::get("/test_rest_text", function () {
    $text = "Цена: 50 рублей.

#кофе";

    $vowels = array("(", ")", "\n");


    $text = str_replace($vowels, "", $text);

    //$lower_text = mb_strtolower($text,"UTF-8");

    $start = mb_strpos($text, "выбор:") + 6;
    $end = mb_strpos($text, "Цена:");

    if ($start == 0 || $end == 0)
        return null;
    $res = mb_substr($text, $start, $end - $start);

    $res = explode("\\", $res);

    $food_sub = [];
    foreach ($res as $r)
        array_push($food_sub, ["name" => trim($r)]);


    //dd($food_sub);


});


Route::get('/test_valid', function () {

    $order = Order::with(["restoran"])
        ->where("id", 2)
        ->first();

    $user = User::find(13333);


    $validator = Validator::make(
        [
            "user" => $user,
            "order" => $order,
        ],
        [
            'user' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value->user_type !== UserTypeEnum::Deliveryman) {
                        $fail('Пользователь не является доставщиком');
                    }
                },
            ],
            'order' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (is_null($user)) {
                        $fail("Ошибка валидации пользователя");
                        return;
                    }

                    if ($value->deliveryman_id !== $user->id) {
                        $fail(sprintf("Заказ #%s не принадлежит доставщику #%s",
                            $value->id,
                            $user->id
                        ));
                    }
                },
            ]

        ],
        [
            'user.required' => 'Пользователь не найден',
            'order.required' => 'Заказ не найден',
        ]);

    if ($validator->fails())
        return response()
            ->json(
                $validator->errors()->toArray(), 500
            );


    $order->deliveryman_id = null;
    $order->save();

    $message = sprintf("Доставщик *#%s* отказался от заказа *#%s*",
        $user->id,
        $order->id
    );


    return response()
        ->json([
            "message" => $message
        ], 200);


});

Route::get("/test_channel", function () {

    try {
        $content = file_get_contents("https://api.telegram.org/bot1144024861:AAEIkP-Cn4RkG4OqHX7OeOnlC6fh2ckDSTY/getChat?chat_id=@dacha_vertu");


    } catch (\Exception $e) {
        $content = [];
    }


    dd(json_decode($content)->result->id ?? 0);
});


Route::get("/test_formated_text", function () {
    function prepareTelegramText(array $text = [])
    {
        $tmp = "";

        foreach ($text as $key => $value) {
            $tmp .= sprintf($key . "\n", $value);
        }

        return $tmp;
    }

    return prepareTelegramText([

        "Заказ:*#%s*" => "123",
        "Заказ:*2#%s*" => "test"

    ]);
});
