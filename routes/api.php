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

Route::post('get-access-token', 'App\Http\Controllers\Api\UserController@getAccessToken')->name('get_access_token');

//get quote
Route::group(['middleware' => 'apiKey'], function () {
    Route::get('quote-data', 'App\Http\Controllers\Api\QuoteController@quoteData')->name('quote_data');
});
