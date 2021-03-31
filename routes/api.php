<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/unauthorized', [AuthController::class, 'unauthorized'])->name('unauthorized');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/registration', [AuthController::class, 'registration']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});
Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/comments/params', [\App\Http\Controllers\Api\Comment\CommentController::class, 'getParams']);

    Route::group(['prefix' => 'startups'], function () {
        Route::get('/params', [\App\Http\Controllers\Api\Startup\StartupController::class, 'getParams']);
        Route::get('/', [\App\Http\Controllers\Api\Startup\StartupController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Startup\StartupController::class, 'store']);
        Route::get('/{startup}', [\App\Http\Controllers\Api\Startup\StartupController::class, 'show']);
        Route::put('/{startup}', [\App\Http\Controllers\Api\Startup\StartupController::class, 'update']);
        Route::delete('/{startup}', [\App\Http\Controllers\Api\Startup\StartupController::class, 'destroy']);
        Route::post('/{startup}/like', [\App\Http\Controllers\Api\Startup\StartupController::class, 'like']);
        Route::group(['prefix' => '/{startup}/comments'], function () {
            Route::get('/', [\App\Http\Controllers\Api\Startup\StartupCommentController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\Startup\StartupCommentController::class, 'store']);
            Route::get('/{comment}', [\App\Http\Controllers\Api\Startup\StartupCommentController::class, 'show']);
            Route::put('/{comment}', [\App\Http\Controllers\Api\Startup\StartupCommentController::class, 'update']);
            Route::delete('/{comment}', [\App\Http\Controllers\Api\Startup\StartupCommentController::class, 'destroy']);
        });
    });

    Route::group(['prefix' => 'donates'], function () {
        Route::get('/params', [\App\Http\Controllers\Api\Donate\DonateController::class, 'getParams']);
        Route::get('/', [\App\Http\Controllers\Api\Donate\DonateController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Donate\DonateController::class, 'store']);
        Route::get('/{donate}', [\App\Http\Controllers\Api\Donate\DonateController::class, 'show']);
    });

    Route::group(['prefix' => 'startup-news'], function () {
        Route::get('/params', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'getParams']);
        Route::get('/', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'store']);
        Route::get('/{startupNews}', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'show']);
        Route::put('/{startupNews}', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'update']);
        Route::delete('/{startupNews}', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'destroy']);
        Route::post('/{startupNews}/like', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'like']);
        Route::group(['prefix' => '/{startupNews}/comments'], function () {
            Route::get('/', [\App\Http\Controllers\Api\StartupNews\StartupNewsCommentController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\StartupNews\StartupNewsCommentController::class, 'store']);
            Route::get('/{comment}', [\App\Http\Controllers\Api\StartupNews\StartupNewsCommentController::class, 'show']);
            Route::put('/{comment}', [\App\Http\Controllers\Api\StartupNews\StartupNewsCommentController::class, 'update']);
            Route::delete('/{comment}', [\App\Http\Controllers\Api\StartupNews\StartupNewsCommentController::class, 'destroy']);
        });
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/params', [\App\Http\Controllers\Api\Category\CategoryController::class, 'getParams']);
        Route::get('/', [\App\Http\Controllers\Api\Category\CategoryController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Category\CategoryController::class, 'store']);
        Route::get('/{category}', [\App\Http\Controllers\Api\Category\CategoryController::class, 'show']);
        Route::put('/{category}', [\App\Http\Controllers\Api\Category\CategoryController::class, 'update']);
        Route::delete('/{category}', [\App\Http\Controllers\Api\Category\CategoryController::class, 'destroy']);
    });
});


