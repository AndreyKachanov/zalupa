<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

$missing = fn(Request $request) => response('Missing route. Not found1111', 404);

Route::post('test', fn(Request $request) => dd($request->all()))->name('api.test');

Route::get('items', [ApiController::class, 'items'])->name('api.items');
//Route::get('items/category/{category:slug}', [ApiController::class, 'getItemsFromCategory'])->name('api.get-items-from-category');
Route::get('items/category/{category:slug}', [ApiController::class, 'getItemsFromParentCategoryAndSubcategories'])->name('api.get-items-from-category');

Route::get('get-categories', [ApiController::class, 'getCategories'])->name('api.get-categories');
Route::get('get-settings', [ApiController::class, 'getSettings'])->name('api.get-settings');

Route::group(
    [
        'prefix'     => 'cart',
        'as'         => 'api.cart.'
    ],
    function () use ($missing) {
        //Route::get('load/{token:token}', [ApiController::class, 'cartLoad'])->name('load')
        //    ->middleware(['throttle:token'])->missing($missing);
        Route::get('load', [ApiController::class, 'cartLoad'])->name('load')
            ->middleware(['throttle:token'])->missing($missing);
        Route::post('add/token/{token:token}/item/{item}/count/{cnt}', [ApiController::class, 'addsItemsToCart'])
            ->name('add')
            ->missing($missing);
        Route::post('remove/{token:token}/{item}', [ApiController::class, 'removeItemsFromCart'])
            ->name('remove')
            ->missing($missing);
        Route::post('set-cnt/{token:token}/{item}/{cnt}', [ApiController::class, 'setCnt'])
            ->name('set-cnt')
            ->missing($missing);
        Route::get('invoice/load', [ApiController::class, 'getBillNumber'])->name('get-bill-number')
            ->missing($missing);
        Route::post('store', [ApiController::class, 'storeOrder'])->name('store-order')
            ->missing($missing);
        //Route::get('new_token', [ApiController::class, 'getNewToken'])->name('get-new-token')
        //    ->missing($missing);
    }
);





Route::fallback(fn() => 'fallback route');
