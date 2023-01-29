<?php

use App\Http\Controllers\Admin\HomeController as AdminHome;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Admin\Items\CategoryController;
use App\Http\Controllers\Admin\Items\OrdersController;
use App\Http\Controllers\Admin\Items\SettingsController;
use App\Http\Controllers\Admin\Items\ItemsController;

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

Route::get('test5', function () {
    $json = '[{"id":"303","title":"\u0428\u0430\u0440 FlyNova Pro","article_number":"0303.1.9003","price1":"370","price2":"360","price3":"350","link":".","img":"items\/f48b9456a2dbd817426fe4d052efd4dd.jpg","category_id":"1","created_at":"2022-02-16 21:28:55","updated_at":"2022-10-01 16:43:09"}]';
    dd(json_decode($json));
});

Route::view('/test', 'test')->name('test');
Route::get('/test2', [TestController::class, 'index'])->name('test2');
Route::get('/test3', [TestController::class, 'index2'])->name('test3');
Route::get('/test4', [TestController::class, 'index3'])->name('test4');

Auth::routes();

Route::get('/login/phone', [LoginController::class, 'phone'])->name('login.phone');
Route::post('/login/phone', [LoginController::class, 'verify']);
Route::get('/verify/{token}', [RegisterController::class, 'verify'])->name('register.verify');

//Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/', 'layouts.app')->name('home');
//Route::view('/', 'home')->name('home');
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
            Route::post('/', [CategoryController::class, 'storeSubCategory'])->name('store');
            Route::get('create', [CategoryController::class, 'createSubCategory'])->name('create');
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
        'search/[0-9a-z\-]*',
    ])
    ->name('any');
