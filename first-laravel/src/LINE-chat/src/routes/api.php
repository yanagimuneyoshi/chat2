<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TalkController;
use App\Http\Controllers\FriendController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// 認証が必要なルート
Route::middleware(['auth:sanctum'])->group(function () {

    // トーク一覧を取得
    Route::get('/talks', [TalkController::class, 'index']);

    // 特定のトークの詳細を取得
    Route::get('/talks/{id}', [TalkController::class, 'show']);

    // トークの作成
    Route::post('/talks', [TalkController::class, 'store']);

    // 友達リストを取得
    Route::get('/friends', [FriendController::class, 'index']);
});