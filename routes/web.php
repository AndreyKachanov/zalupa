<?php

use App\Http\Controllers\Admin\HomeController as AdminHome;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Admin\Cart\Invoice;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Items\CategoryController;
use App\Http\Controllers\Admin\Items\OrdersController;
use App\Http\Controllers\Admin\Items\SettingsController;
use App\Http\Controllers\Admin\Items\ItemsController;

Auth::routes();

Route::get('/login/phone', [LoginController::class, 'phone'])->name('login.phone');
Route::post('/login/phone', [LoginController::class, 'verify']);
Route::get('/verify/{token}', [RegisterController::class, 'verify'])->name('register.verify');

//Route::get('test', function () {
//
//    $maxId = Invoice::max('id');
//    //dd(str_pad($maxId + ($maxId + 10), 5, '0', STR_PAD_LEFT));
//
//    dd(Invoice::create([
//        'bill_number' => date('Y') . '-' . str_pad($maxId*33, 6, '0', STR_PAD_LEFT),
//        'token_id' => 1
//    ])->bill_number);
//});


Route::view('/', 'layouts.app')->name('home');
Route::group(
    [
        'prefix'     => 'admin',
        'as'         => 'admin.',
        'namespace'  => 'Admin',
        'middleware' => ['auth', 'can:admin-panel']
    ],
    function () {
        Route::group(['prefix' => 'subcategories', 'as' => 'subcategories.'], function () {
            Route::get('/', [CategoryController::class, 'indexSubCategories'])->name('index');
            Route::post('/{category}', [CategoryController::class, 'storeSubCategory'])->name('store');
            Route::get('create/{category}', [CategoryController::class, 'createSubCategory'])->name('create');
            Route::get('{category}', [CategoryController::class, 'showSubCategory'])->name('show');
            Route::get('{category}/edit', [CategoryController::class, 'editSubCategory'])->name('edit');
            Route::match(['put', 'patch'], '{category}', [CategoryController::class, 'updateSubCategory'])
                ->name('update');
            Route::delete('{category}', [CategoryController::class, 'destroySubCategory'])->name('destroy');
        });
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('/', [SettingsController::class, 'index'])->name('index');
            Route::post('/', [SettingsController::class, 'update'])->name('update');
        });
        Route::get('/', [AdminHome::class, 'index'])->name('home');
        Route::resource('items', 'Items\ItemsController');
        Route::resource('categories', 'Items\CategoryController');
        Route::resource('orders', OrdersController::class);
        Route::resource('users', 'UsersController');
        Route::post('/users/{user}/verify', 'UsersController@verify')->name('users.verify');
        //Subcategories for sub menu in create and edit items
        Route::get('/getSubcategories/{id}', [ItemsController::class, 'getSubCategories'])->name('get_subcategories');
    }
);

//Маршрут под vue-router - чтобы после перезагрузки работали страницы
Route::get('/{any}', fn() => view('layouts.app'))
    ->whereIn('any', [
        'cart',
        'order',
        'contacts',
        'search',
        //'product/[0-9]',
        //'category/1-populyarnye-tovary',
        //'category/sub-1-main-1-populyarnye-tovary',
        'category/[0-9a-z\-]*',
        'product/[0-9a-z\-]*',
    ])
    ->name('any');
