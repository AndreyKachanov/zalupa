<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\HomeController as AdminHome;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/login/phone', [LoginController::class, 'phone'])->name('login.phone');
Route::post('/login/phone', [LoginController::class, 'verify']);
Route::get('/verify/{token}', [RegisterController::class, 'verify'])->name('register.verify');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::group(
    [
        'prefix'     => 'admin',
        'as'         => 'admin.',
        'namespace'  => 'Admin',
        //'middleware' => ['auth', 'can:admin-panel']
    ],
    function () {
        //Route::get('/', 'HomeController@index')->name('home');
        Route::get('/', [AdminHome::class, 'index'])->name('home');
        Route::resource('items', 'Items\ItemsController');
        Route::resource('categories', 'Items\CategoryController');
        Route::get('parser', 'VkParsingPostsController@index')->name('parser.index');
        Route::post('start_parse', 'VkParsingPostsController@startParse')->name('start_parse');
        Route::resource('users', 'UsersController');
        Route::post('/users/{user}/verify', 'UsersController@verify')->name('users.verify');
    }
);
