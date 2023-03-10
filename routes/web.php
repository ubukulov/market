<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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
Route::get('/login', [AuthController::class, 'loginForm'])->name('loginForm');
Route::get('/restore-password', [AuthController::class, 'restorePassword'])->name('restorePassword');
Route::get('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');

# Category
Route::get('category/{id}', [CategoryController::class, 'show'])->name('category.products');
