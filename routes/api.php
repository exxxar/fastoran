<?php

use App\Parts\Models\Fastoran\Kitchen;
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
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('/wish', 'RestController@sendWish');

    Route::get('/kitchen-list', 'RestController@getKitchenList');

    Route::get('/rest/{domain}', 'RestController@getRestByDomain');

    Route::get('/categories', 'RestController@getCategories');
    Route::get('/razdels', 'RestController@getRazdels');
    Route::get('/rubricks', 'RestController@getRubriks');

    Route::get('/menu/{id}', 'RestController@getMenuByRestoran');

    Route::get('/rest-list', 'RestController@getRestList');
    Route::get('/rest-list/kitchen/{id}', 'RestController@getRestListByKitchen');
    Route::post('/send-request', 'RestController@sendRequest')->name("callback.request");



    Route::group([
        'namespace' => 'Fastoran',
        'prefix' => 'fastoran'
    ], function () {
        Route::resource('restorans', 'RestoransController');
        Route::resource('cetegories', 'CategoryController');
        Route::resource('kitchens', 'KitchenController');
        Route::resource('menu_categories', 'MenuCategoryController');
        Route::resource('menus', 'MenuController');
        Route::resource('regions', 'RegionController');
        Route::resource('menu_razdels', 'MenuRazdelController');
        Route::resource('menu_rubriks', 'MenuRubrikController');
        Route::resource('orders', 'OrderController');
        Route::resource('order_details', 'OrderDetailController');

        Route::get("restorans/like/{id}",'RestoransController@like');
        Route::get("restorans/dislike/{id}",'RestoransController@dislike');

        Route::any('kitchens', 'KitchenController@index');
        Route::any('menu_categories', 'MenuCategoryController@index');

    });

    Route::group([
        'namespace' => 'Api',
        'prefix' => 'auth'
    ], function () {

        Route::post('/check/{type}', 'AuthController@checkUserExist')->where(["type"=>"[0-9]+"]);

        Route::post('/sms', 'AuthController@sendSmsVerify');
        Route::post('/verify', 'AuthController@checkVerifyUser');

        Route::post('login', 'AuthController@login');
        Route::post('signup_telegram', 'AuthController@signupTelegram');
        Route::post('signup', 'AuthController@signup');

        Route::get('signup/activate/{token}', 'AuthController@signupActivate')->name("signup.verify");

        Route::group([
            'middleware' => 'auth:api'
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
        Route::get('test', function () {
            return "test";
        });
    });

    Route::group([
        'prefix' => 'methods',
        'middleware' => 'auth:api'
    ], function () {
        Route::any('history', 'RestController@getOrderHistory');
        Route::post('order', 'RestContoller@makeOrder');
    });

});



