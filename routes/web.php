<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect()->route('posts.index');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

/**
 * ユーザ
 */
// プロフィール画像機能実装時追加する
// Route::get('/users/edit_image', [UserController::class, 'editImage'])->name('users.edit_image');
// Route::patch('/users/edit_image', [UserController::class, 'updateImage'])->name('users.update_image');
 
Route::resource('users', UserController::class)->only([
  'show',
]);

// アカウント設定
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 認証
require __DIR__.'/auth.php';


/**
 * 投稿
 */
Route::resource('posts', PostController::class);

/**
 * フォロー
 */
Route::resource('follows', FollowController::class)->only([
    'index', 'store', 'destroy'
]);

Route::get('/follower', [FollowController::class, 'followerIndex']);
