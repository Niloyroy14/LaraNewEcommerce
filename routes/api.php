<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



//Brand Api
Route::group(['prefix'=>'v1','namespace'=>'Api'], function () {
    Route::resource('/brands', BrandController::class);
    Route::resource('/category', CategoryController::class);
});









//cart Api route for ajax

Route::post('/product/cart/store','API\CartsController@product_cart_store')->name('product.cart.store');

