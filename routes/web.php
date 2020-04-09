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
use App\Parts\Models\Fastoran\Order;
use App\Parts\Models\Fastoran\OrderDetail;
use App\Parts\Models\Fastoran\RestMenu;
use App\Parts\Models\Fastoran\Restoran;
use App\Rating;
use App\User;
use ATehnix\VkClient\Auth as VkAuth;
use ATehnix\VkClient\Client;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;


Route::get('/', 'RestController@getMainPage');
Route::any('/search', 'RestController@searchFood')->name("search");

Route::get('/rest/{domain}', 'RestController@getRestByDomain')->name("rest");
Route::get('/all-menu', 'RestController@getAllMenu')->name("all.menu");
Route::get('/cart', 'RestController@getCart')->name("cart");
Route::get('/checkout', 'RestController@getCheckout')->name("checkout");

Route::get('/kitchen-list', 'RestController@getKitchenList')->name("kitchen-list");
Route::get('/rest-list', 'RestController@getRestList')->name("rest-list");
Route::get('/rest-list/kitchen/{id}', 'RestController@getRestListByKitchen')->name("kitchen");

Route::view("/faq", "fastoran.faq")->name("faq");
Route::view("/about", "fastoran.about")->name("about");
Route::view("/partner", "fastoran.partner")->name("partner");


Route::view("/contacts", "fastoran.contacts")->name("contacts");
Route::view("/success", "fastoran.success")->name("success");

Route::view("/questions", "fastoran.questions")->name("questions");
Route::view("/agreement", "fastoran.agreement")->name("agreement");
Route::view("/terms-of-user", "fastoran.terms-of-use")->name("terms");


//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vkontakte', "HomeController@uploadVk");

/*Route::prefix('admin')->group(function () {
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
});*/


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
