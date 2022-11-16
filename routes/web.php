<?php

use App\Http\Controllers\Admin\HomeController as AdminHome;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Admin\Item\Item;
use App\Models\Admin\Item\Category;
use App\Models\Admin\Cart\CartItem;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

//Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/', 'layouts.app')->name('home');
Route::group(
    [
        'prefix'     => 'admin',
        'as'         => 'admin.',
        'namespace'  => 'Admin',
        'middleware' => ['auth', 'can:admin-panel']
    ],
    function () {
        Route::get('/', [AdminHome::class, 'index'])->name('home');
        Route::resource('items', 'Items\ItemsController');
        Route::resource('categories', 'Items\CategoryController');
        Route::resource('users', 'UsersController');
        Route::post('/users/{user}/verify', 'UsersController@verify')->name('users.verify');
    }
);

Route::get('/categories/{category}/items/{item}', function (Category $category, Item $item) {
    dump($item);
    dump($category);
})->scopeBindings()->missing(fn(Request $request) => Redirect::route('home'));
