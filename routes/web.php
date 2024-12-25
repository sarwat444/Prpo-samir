<?php
use Illuminate\Support\Facades\Route;
//define('PAGINATION_COUNT',10);
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
Route::get('/','Admin\LoginController@getLogin')->name('get.admin.login2');


Route::get('/shop/product_details/{id}' , 'indexController@productdetails') ;
Route::get('/shop/model_maker/{id}' , 'indexController@modeldetails') ;

Route::group(['prefix' => 'offers','namespace' =>'Offers'], function () {
    Route::get('/', 'OfferController@index')->name('offers.all');
    Route::get('details/{offer_id}', 'OfferController@show')->name('offers.show');
});

Route::get('get-checkout-id', 'PaymentProviderController@getCheckOutId')->name('offers.checkout');
