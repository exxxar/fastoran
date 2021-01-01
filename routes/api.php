<?php

use App\Parts\Models\Fastoran\Section;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});;

Route::group(['prefix'=>'v2'],function (){

    Route::group([
        'namespace' => 'ObedyGo',
        'prefix' => 'obedy'
    ], function () {
        Route::get('products', 'ObedyGoController@getProductList');
        Route::get('categories', 'ObedyGoController@getCategoryList');
        Route::post('order', 'ObedyGoController@order');


        Route::group([
           'prefix' => 'lottery'
        ], function () {
            Route::get('/all', 'LotteryController@getLotteryList');
            Route::get('/get/{id}', 'LotteryController@getLottery');
            Route::post('/pick', 'LotteryController@pickPlace');
        });
    });
});



Route::group(['prefix' => 'v1'], function () {

    Route::get("/maintenance",function (){
       return response()->json([
          "status"=>false,
          "message"=>"Example"
       ]);
    });
    Route::post("/range/{restId}","Fastoran\OrderController@getRange");
    Route::post("/range_with_route/{restId}","Fastoran\OrderController@getRangeWithRoute");

    Route::post("/custom_range","Fastoran\OrderController@getCustomRange");

    Route::post('/wish', 'RestController@sendWish')->name("wish");

    Route::get('/kitchen-list', 'RestController@getKitchenList');

    Route::get('/rest/{domain}', 'RestController@getRestByDomain');

    Route::get('/categories', 'RestController@getCategories');
    Route::get('/razdels', 'RestController@getRazdels');
    Route::get('/rubricks', 'RestController@getRubriks');

    Route::get('/menu/{id}', 'RestController@getMenuByRestoran');

    Route::get('/rest-list', 'RestController@getRestList');
    Route::get('/rest-list/kitchen/{id}', 'RestController@getRestListByKitchen');
    Route::post('/send-request', 'RestController@sendRequest')->name("callback.request");

    Route::get("/restoran/cities", "Fastoran\\RestoransController@cities")->name("cities");

    Route::group([
        'namespace' => 'Fastoran',
        'prefix' => 'fastoran'
    ], function () {

        Route::post('order/sms', 'OrderController@sendSmsVerify');
        Route::post('order/resend', 'OrderController@resendSmsVerify');
        Route::post('order/custom', 'OrderController@sendCustomOrder');
        Route::post('order/phone', 'OrderController@sendPhoneOrder');
        Route::post('order/flowers', 'OrderController@sendFlowersOrder');
        Route::post('order/quest', 'OrderController@sendDeliverymanQuest');
        Route::post('order/price_by_code', 'PromocodeController@getPriceByCode');
        Route::get('order/latest', 'OrderController@getLatestOrders');
        Route::post('order/history', 'OrderController@getOrdersHistory');

        Route::post("check_valid_code", "OrderController@checkValidCode");

        Route::get("restorans/cities", 'RestoransController@cities');
        Route::get("restorans/cities/{name}", 'RestoransController@getRestoransInCity')
            ->where(["name"=>"[а-яА-Я0-9]{2,20}"]);

        Route::resource('restorans', 'RestoransController');
        Route::resource('kitchens', 'SectionController');
        Route::resource('menu_categories', 'MenuCategoryController');
        Route::resource('menus', 'MenuController');
        Route::resource('orders', 'OrderController');
        Route::resource('order_details', 'OrderDetailController');

        Route::any("orders/{id}", "OrderController@show");

        Route::get("restorans/like/{id}", 'RestoransController@like');


        Route::get("restorans/dislike/{id}", 'RestoransController@dislike');

        Route::any('kitchens', 'SectionController@index');
        Route::any('menu_categories', 'MenuCategoryController@index');
        Route::any('menu_categories_in_rest/{rest_id}', 'MenuCategoryController@menuCategoriesInRest');
        Route::any('sales', 'RestoransController@sales');
        Route::any('products_by_rest_and_category/{cat_id}/{rest_id}', 'MenuCategoryController@showByRestAndCategory');
        Route::any('restorans', 'RestoransController@index');
        Route::any('sections', 'RestoransController@sections');
        Route::any('sections/{id}', 'RestoransController@showSection');
        Route::any('menus', 'MenuController@index');


        Route::any('/restorans/menu/{restId}', 'MenuController@getMenuByRestId');
        Route::any('/restorans/section/{sectionId}', 'RestoransController@getRestoransBySectionId');

        Route::any('/kitchens/menu/{kitchenId}', 'SectionController@getMenuByKitchenId');


        Route::group([
            'middleware' => 'auth:api',

        ], function () {

            Route::post("generate_promocode", "PromocodeController@generate");

            Route::any('/history', 'OrderController@getOrderHistory');
            Route::any("accept_order/{id}", "OrderController@acceptOrder");
            Route::any("deliveryman_orders", "OrderController@getDeliverymanOrders");
            Route::any("deliveryman_order_location", "OrderController@setDeliverymanLocation");
            Route::any("decline_order/{id}", "OrderController@declineOrder");
            Route::any("decline_order_by_admin/{id}", "OrderController@declineOrderAdmin");
            Route::any("set_deliveryman_type/{type}", "OrderController@setDeliverymanType")->where(["type"=>"[0-9]+"]);
            Route::any("order/{id}", "OrderController@getOrderById")->where(["id"=>"[0-9]+"]);
            Route::any("order/status/delivered/{id}", "OrderController@setDeliveredStatus");
            Route::any("order/comment/{id}", "OrderController@setCommentToOrder");

        });
    });

    Route::group([
        'namespace' => 'Api',
        'prefix' => 'auth'
    ], function () {

        Route::post('/check/{type}', 'AuthController@checkUserExist')->where(["type" => "[0-9]+"]);

        Route::post('/sms', 'AuthController@sendSmsVerify');
        Route::post('/verify', 'AuthController@checkVerifyUser');

        Route::post('login', 'AuthController@login');
        Route::post('login_phone', 'AuthController@loginPhone');
        Route::post('signup_telegram', 'AuthController@signupTelegram');
        Route::post('modify_telegram', 'AuthController@modifyTelegram');
        Route::post('signup_phone', 'AuthController@signupPhone')->name("api.signup.phone");
        Route::post('signup', 'AuthController@signup');

        Route::get('signup/activate/{token}', 'AuthController@signupActivate')->name("signup.verify");

        Route::group([
            'middleware' => 'auth:api',

        ], function () {
            Route::any('logout', 'AuthController@logout');
            Route::any('user', 'AuthController@user');

        });
    });

    Route::group([
        'namespace' => 'Api',
        'middleware' => 'api',
        'prefix' => 'password'
    ], function () {
        Route::post('create', 'PasswordResetController@create');
        Route::get('find/{token}', 'PasswordResetController@find');
        Route::post('reset', 'PasswordResetController@reset');

    });

    Route::group([
        'prefix' => 'methods',
        'middleware' => 'auth:api'
    ], function () {

        Route::post('order', 'RestContoller@makeOrder');
    });

});

Route::fallback(function(){
    return response()->json([
        'message' => 'Маршрут не найден!'], 404);
});





