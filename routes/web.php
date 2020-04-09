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
use App\Parts\Models\Fastoran\Rating;
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

Route::view("/questions", "fastoran.questions")->name("questions");
Route::view("/agreement", "fastoran.agreement")->name("agreement");
Route::view("/terms-of-user", "fastoran.terms-of-use")->name("terms");


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vkontakte', "HomeController@uploadVk");


Route::prefix('admin')->group(function () {
    Route::any("/", 'Admin\AdminController@index')->name("admin.main");
    Route::get('/vkontakte', "Admin\AdminController@uploadVk");

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

    Route::any('/orders', 'Admin\OrderController@index');
    Route::get('/orders/get', 'Admin\OrderController@get');
    Route::post('/orders/store', 'Admin\OrderController@store');
    Route::put('/orders/update/{id}', 'Admin\OrderController@update');
    Route::delete('/orders/destroy/{id}', 'Admin\OrderController@destroy');
    Route::post('/orders/restore/{id}', 'Admin\OrderController@restore');
    Route::any('/history', 'Admin\OrderController@getOrderHistory');
    Route::get('/orders/getDetails/{id}', 'Admin\OrderController@getDetails');

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
Route::get("/test_geo",function(){
    $data = YaGeo::setQuery('Донецк, ул. Артема')->load();
    $data = $data->getResponse()->getLatitude();
    dd($data);

});
Route::get("/test_deliveryman",function (){
    $orders = Order::with(["details", "restoran", "details.product", "user"])
        ->where("deliveryman_id", 5)
        ->get();

    dd($orders);
});
