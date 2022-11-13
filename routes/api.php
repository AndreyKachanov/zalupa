<?php

use App\Http\Controllers\ApiController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('items', [ApiController::class, 'items'])->name('api.items');
Route::group(
    [
        'prefix'     => 'cart',
        'as'         => 'api.cart.'
    ],
    function () {
        Route::get('load', [ApiController::class, 'cartLoad'])->name('load');
        Route::get('add', [ApiController::class, 'addsItemsToCart'])->name('add');
        //Route::get('remove/token/{token}/id/{item}', [ApiController::class, 'removeItemsFromCart'])->name('remove');
        Route::get('remove', [ApiController::class, 'removeItemsFromCart'])->name('remove');
        //Route::get('remove/{token:token}/{item}', [ApiController::class, 'removeItemsFromCart'])->name('remove');
    }
);
