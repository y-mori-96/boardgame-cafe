<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\BoardgameController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RentalItemController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReviewController;

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

Route::get('/', function () {
    return view('top');
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

/**
 * ボードゲーム一覧
 */
// Route::get('/boardgames', [BoardgameController::class, 'index'])->name('boardgames.index');
Route::resource('boardgames', BoardgameController::class)->only([
  'index', 'show',
]);
Route::get('/boardgames/{boardgame}/review/create', [BoardgameController::class, 'reviewCreate'])->name('review.create');
Route::post('/boardgames/{boardgame}/review/store', [BoardgameController::class, 'reviewStore'])->name('review.store');
Route::get('/review/{review}/edit', [BoardgameController::class, 'reviewEdit'])->name('review.edit');
Route::patch('/review/{review}', [BoardgameController::class, 'reviewUpdate'])->name('review.update');
Route::delete('/review/{review}', [BoardgameController::class, 'reviewDestroy'])->name('review.destroy');

// レビュー
// Route::resource('reviews', ReviewController::class)->only([
//   'create', 'store', 'destroy'
// ]);

/**
 * EC
 */
Route::resource('exhibitions', ExhibitionController::class)->only([
  'index', 'show',
]);

// 注文
Route::patch('/exhibitions/{exhibition}/add_soldExhibition', [ExhibitionController::class, 'addSoldItem'])->name('exhibitions.add_soldItem');
Route::get('/exhibitions/{exhibition}/finish', [ExhibitionController::class, 'finish'])->name('exhibitions.finish');

// カート
Route::resource('cart', CartController::class)->only([
  'index', 'destroy',
]);
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart/success', [CartController::class, 'success'])->name('cart.success');
Route::get('/cart/cancel', [CartController::class, 'cancel'])->name('cart.cancel');

/**
 * レンタル
 */
Route::resource('rental-items', RentalItemController::class)->only([
  'index', 'show',
]);

// 貸し出し状況
Route::resource('rental', RentalController::class)->only([
  'index', 'destroy',
]);
Route::post('/add', [RentalController::class, 'add'])->name('rental.add');