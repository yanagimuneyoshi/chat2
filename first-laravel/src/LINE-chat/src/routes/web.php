<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\MessagesController;

// 認証不要なルート
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ユーザー登録
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// 認証が必要なルート
Route::middleware('auth')->group(function () {
    // ダッシュボードの表示
    // Route::get('/', [LoginController::class, 'showDashboard'])->name('dashboard');

    // メッセージ関連
    // Route::post('/messages', [MessagesController::class, 'store']);
    Route::get('/messages/{chatId}', [MessagesController::class, 'index']);
    Route::post('/messages', [MessagesController::class, 'sendMessage'])->name('messages.send');

    // SPAのエントリポイント
    Route::get('/{any}', function () {
        return view('app'); // Vue.jsアプリのエントリビューを返す
    })->where('any', '.*');
});

use App\Http\Controllers\TalkController;

Route::get('/talks', [TalkController::class, 'index'])->name('talks.index');

use App\Http\Controllers\FriendController;

Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
