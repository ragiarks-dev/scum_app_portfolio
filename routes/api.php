<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//アカウント仮登録
Route::post('/register_account', [\App\Http\Controllers\ProvisionalUserController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    //最高管理者のみアクセス可能
    Route::group(['middleware' => 'can:system-admin', 'prefix' => 'admin'], function () {
        //ログファイルの手動更新
        Route::post('/update_log_file', [\App\Http\Controllers\ScumLogController::class, 'logFileModelUpdate']);

        //管理画面 ユーザー機能
        Route::post('/users/store', [\App\Http\Controllers\UserController::class, 'store']);
        Route::post('/users/update/{user}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::post('/users/revive/{user}', [\App\Http\Controllers\UserController::class, 'revive']);
        Route::post('/users/restrict/{user}', [\App\Http\Controllers\UserController::class, 'restrict']);
        Route::post('/users/ban/{user}', [\App\Http\Controllers\UserController::class, 'ban']);
        Route::post('/users/grant_cash/{user}', [\App\Http\Controllers\UserController::class, 'grantCash']);

        //管理画面　報告機能
        Route::post('/reports/destroy', [\App\Http\Controllers\ReportController::class, 'destroys']);
    });

    //一般管理者以上でアクセス可能
    Route::group(['middleware' => 'can:admin', 'prefix' => 'admin'], function () {

        //管理画面 ユーザー機能
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);

        //管理画面　報告機能
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index']);
    });

    //報告機能
    Route::post('/send_report', [\App\Http\Controllers\ReportController::class, 'sendReport']);
});

Route::post('/test', [\App\Http\Controllers\TestController::class, 'test']);
