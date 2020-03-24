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


use App\Parts\Models\Fastoran\Restoran;

Route::get('/', 'RestController@getMainPage');
Route::get('/test', function (){
    $rest = Restoran::with(["menus"])->where('url',"test7")->first();

    dd($rest);
});


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
    ]);
});
