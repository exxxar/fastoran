<?php

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

Route::get('/rest/{domain}', 'RestController@getRestByDomain');

Route::get('/categories', 'RestController@getCategories');
Route::get('/razdels', 'RestController@getRazdels');
Route::get('/rubricks', 'RestController@getRubriks');

Route::get('/menu/{id}', 'RestController@getMenuByRestoran');

Route::get('/region-list', 'RestController@getRestByDomain');

Route::get('/kitchen-list', 'RestController@getKitchenList');

Route::get('/rest-list', 'RestController@getRestList');
Route::get('/rest-list/kitchen/{id}', 'RestController@getRestListByKitchen');
