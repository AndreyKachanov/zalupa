<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\HomeController;
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
        Route::get('load', [ApiController::class, 'load'])->name('load');
        Route::get('add', [ApiController::class, 'add'])->name('add');
    }
);



