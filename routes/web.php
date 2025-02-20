<?php

use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\FollowersController;



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

Route::get('/', [StaticPagesController::class,'home'])->name('home');
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

// http://127.0.0.1:8000/signup/confirm/{token}
// http://lravel-blog.local/signup/confirm/{token}
Route::get('signup/confirm/{token}', [UsersController::class,'confirmEmail'])->name('confirm_email');

// 展示重置密码的邮箱发送页面
Route::get('password/reset', [PasswordController::class, 'showLinkRequestForm'])->name('password.request');
// 提交邮箱地址，发送重置密码邮件
Route::post('password/email', [PasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// 显示更新密码的表单
Route::get('password/reset/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
// 提交更新密码的表单, 重置密码
Route::post('password/reset', [PasswordController::class, 'reset'])->name('password.update');

// 微博相关操作
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);

// 用户的关注列表
Route::get('users/{user}/followings', [UsersController::class, 'followings'])->name('users.followings');
// 用户的粉丝列表
Route::get('users/{user}/followers', [UsersController::class, 'followers'])->name('users.followers');

// 关注用户
Route::post('users/followers/{user}', [FollowersController::class, 'store'])->name('followers.store');
// 取消关注用户
Route::delete('users/followers/{user}', [FollowersController::class, 'destroy'])->name('followers.destroy');


