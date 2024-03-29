<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
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

Route::get('/', [IndexController::class, 'welcome'])->name('home');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::get('/restore-password', [AuthController::class, 'restorePassword'])->name('restorePassword');
Route::get('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');
Route::post('/registration', [AuthController::class, 'registration']);
Route::post('authentication', [AuthController::class, 'authentication'])->name('authentication');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

# Category
Route::get('c/{slug}', [CategoryController::class, 'show'])->name('category.products');
Route::get('p/{slug}', [ProductController::class, 'show'])->name('product.page');
Route::get('/get-categories-list', [CategoryController::class, 'getCategoryList']);
Route::post('/c/{slug}/get-products-by-filter', [CategoryController::class, 'getProductsByFilter']);

// Только авторизованные пользователи могут посмотреть
Route::group(['middleware' => ['auth']], function(){
    # Cart
    Route::group(['prefix' => 'cart'], function(){
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::get('{hash}/delete', [CartController::class, 'delete'])->name('cart.delete');
        Route::get('/empty', [CartController::class, 'cartEmpty'])->name('cart.empty');
        Route::get('/order', [CartController::class, 'order'])->name('cart.order');
    });

    # Cabinet
    Route::group(['prefix' => 'cabinet', 'middleware' => ['auth']], function(){
        Route::get('profile', [UserController::class, 'profile'])->name('cabinet.profile');
        Route::get('order/{id}/items', [UserController::class, 'getOrderItems']);
    });

    # My Store
    Route::group(['prefix' => 'store'], function(){
        Route::get('/', [StoreController::class, 'index'])->name('store.index');
    });

    # Настройки маркетплейсов пользователя
    Route::get('get-marketplaces', [StoreController::class, 'getMarketPlaces']);
    Route::post('marketplace/category/margins', [StoreController::class, 'saveMarketPlaceCategoryMargins']);
});
