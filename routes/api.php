<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/unauthorized', function () {
   return response()->json(['error' => 'Unauthorized']);
})->name('unauthorized');

Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'is_auth'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });
});
