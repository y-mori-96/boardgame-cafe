<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\BoardgamesController;
use App\Http\Controllers\Admin\ExhibitionsController;
use App\Http\Controllers\Admin\RentalItemController;
use App\Http\Controllers\Admin\RentalController;

// use App\Http\Controllers\UserController;
// use App\Http\Controllers\PostController;


use App\Http\Controllers\Admin\ProfileController;
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
//     return view('admin.welcome');
// });
// Route::get('/', function () {
//     return redirect()->route('posts.index');
// });

/**
 * ユーザ管理
 */
Route::resource('users', UsersController::class)
    ->middleware('auth:admin')->only(['index']);
Route::get('/users/rentals', [UsersController::class, 'rentals'])->name('users.rentals')
    ->middleware('auth:admin');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth:admin', 'verified'])->name('dashboard');

/**
 * ユーザ
 */
// プロフィール画像機能実装時追加する
// Route::get('/users/edit_image', [UserController::class, 'editImage'])->name('users.edit_image');
// Route::patch('/users/edit_image', [UserController::class, 'updateImage'])->name('users.update_image');
 
// Route::resource('users', UserController::class)->only([
//   'show',
// ]);

// アカウント設定
Route::middleware('auth:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    /**
     * ボードゲーム管理
     */
    Route::resource('boardgames', BoardgamesController::class);
    Route::get('/boardgames/{boardgame}/edit_image', [BoardgamesController::class, 'editImage'])->name('boardgames.edit_image');
    Route::patch('/boardgames/{boardgame}/edit_image', [BoardgamesController::class, 'updateImage'])->name('boardgames.update_image');
    // Route::get('/boardgames/{boardgame}/edit', [BoardgamesController::class, 'edit']);
    // Route::patch('/boardgames/{boardgame}/edit', [BoardgamesController::class, 'updateImage']);
    Route::get('/boardgames/{boardgame}/review/create', [BoardgameController::class, 'reviewCreate'])->name('review.create');
    Route::post('/boardgames/{boardgame}/review/store', [BoardgameController::class, 'reviewStore'])->name('review.store');
    Route::get('/review/{review}/edit', [BoardgameController::class, 'reviewEdit'])->name('review.edit');
    Route::patch('/review/{review}', [BoardgameController::class, 'reviewUpdate'])->name('review.update');
    Route::delete('/review/{review}', [BoardgameController::class, 'reviewDestroy'])->name('review.destroy');
});


/**
 * EC
 */
Route::resource('exhibitions', ExhibitionsController::class)
    ->middleware('auth:admin');
 
/**
 * レンタル
 */ 
Route::resource('rental-items', RentalItemController::class)
    ->middleware('auth:admin');

// 貸し出し状況
Route::resource('rentals', RentalController::class)
    ->only(['index', 'destroy',])
    ->middleware('auth:admin');
    
Route::post('/rentals/permission/{rental}', [RentalController::class, 'permission'])->name('rentals.permission')
    ->middleware('auth:admin');
Route::post('/rentals/completion/{rental}', [RentalController::class, 'completion'])->name('rentals.completion')
    ->middleware('auth:admin');

/**
 * 認証
 */
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});




