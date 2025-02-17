<?php

use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticPagesController;

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

Route::get('/home', [StaticPagesController::class,'home'])->name('home');
Route::get('/help', [StaticPagesController::class,'help'])->name('help');

Route::get('/about', [StaticPagesController::class,'about'])->name('about');

Route::get('signup', [UsersController::class,'create'])->name('signup');
Route ::resource('users', UsersController::class);

// 展示登录页面
Route::get('login', [SessionsController::class,'create'])->name('login');
// 创建新会话（登录）
Route::post('login', [SessionsController::class,'store'])->name('login');
// 销毁会话（退出登录）
Route::delete('logout', [SessionsController::class,'destroy'])->name('logout');

