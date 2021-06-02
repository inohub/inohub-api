<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/unauthorized', [AuthController::class, 'unauthorized'])->name('unauthorized');

Route::group(['prefix' => 'auth'], function () {
    Route::post('/registration', [AuthController::class, 'registration']);
    Route::post('/attach-role', [AuthController::class, 'attachRole']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::group(['prefix' => 'lists'], function () {
    Route::get('/startup-status', [\App\Http\Controllers\Api\Lists\ListsController::class, 'startupStatus']);
});

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/roles', [\App\Http\Controllers\Api\Role\RoleController::class, 'index']);

    Route::group(['prefix' => 'startups'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Startup\StartupController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Startup\StartupController::class, 'store']);
        Route::get('/{startup}', [\App\Http\Controllers\Api\Startup\StartupController::class, 'show']);
        Route::put('/{startup}', [\App\Http\Controllers\Api\Startup\StartupController::class, 'update']);
        Route::delete('/{startup}', [\App\Http\Controllers\Api\Startup\StartupController::class, 'destroy']);
        Route::post('/{startup}/publish', [\App\Http\Controllers\Api\Startup\StartupController::class, 'publish']);
        Route::post('/{startup}/approve', [\App\Http\Controllers\Api\Startup\StartupController::class, 'approve']);
        Route::post('/{startup}/archive', [\App\Http\Controllers\Api\Startup\StartupController::class, 'archive']);
        Route::post('/{startup}/block', [\App\Http\Controllers\Api\Startup\StartupController::class, 'block']);
        Route::group(['prefix' => '/{startup}/media'], function () {
            Route::post('store-preview-image', [\App\Http\Controllers\Api\Startup\StartupMediaController::class, 'storeStartupPreviewImage']);
            Route::post('store-preview-video', [\App\Http\Controllers\Api\Startup\StartupMediaController::class, 'storeStartupPreviewVideo']);
        });
        Route::group(['prefix' => '/{startup}/comments'], function () {
            Route::get('/', [\App\Http\Controllers\Api\Startup\StartupCommentController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\Startup\StartupCommentController::class, 'store']);
            Route::get('/{comment}', [\App\Http\Controllers\Api\Startup\StartupCommentController::class, 'show']);
            Route::put('/{comment}', [\App\Http\Controllers\Api\Startup\StartupCommentController::class, 'update']);
            Route::delete('/{comment}', [\App\Http\Controllers\Api\Startup\StartupCommentController::class, 'destroy']);
        });
        Route::group(['prefix' => '/{startup}/likes'], function () {
            Route::get('/', [\App\Http\Controllers\Api\Startup\StartupLikeController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\Startup\StartupLikeController::class, 'like']);
            Route::get('/count', [\App\Http\Controllers\Api\Startup\StartupLikeController::class, 'likeCount']);
        });
    });

    Route::group(['prefix' => 'donates'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Donate\DonateController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Donate\DonateController::class, 'store']);
        Route::get('/{donate}', [\App\Http\Controllers\Api\Donate\DonateController::class, 'show']);
    });

    Route::group(['prefix' => 'startup-news'], function () {
        Route::get('/', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'store']);
        Route::get('/{startupNews}', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'show']);
        Route::put('/{startupNews}', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'update']);
        Route::delete('/{startupNews}', [\App\Http\Controllers\Api\StartupNews\StartupNewsController::class, 'destroy']);
        Route::group(['prefix' => '/{startupNews}/comments'], function () {
            Route::get('/', [\App\Http\Controllers\Api\StartupNews\StartupNewsCommentController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\StartupNews\StartupNewsCommentController::class, 'store']);
            Route::get('/{comment}', [\App\Http\Controllers\Api\StartupNews\StartupNewsCommentController::class, 'show']);
            Route::put('/{comment}', [\App\Http\Controllers\Api\StartupNews\StartupNewsCommentController::class, 'update']);
            Route::delete('/{comment}', [\App\Http\Controllers\Api\StartupNews\StartupNewsCommentController::class, 'destroy']);
        });
        Route::group(['prefix' => '/{startupNews}/likes'], function () {
            Route::get('/', [\App\Http\Controllers\Api\StartupNews\StartupNewsLikeController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\StartupNews\StartupNewsLikeController::class, 'like']);
            Route::get('/count', [\App\Http\Controllers\Api\StartupNews\StartupNewsLikeController::class, 'likeCount']);
        });
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Category\CategoryController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Category\CategoryController::class, 'store']);
        Route::get('/{category}', [\App\Http\Controllers\Api\Category\CategoryController::class, 'show']);
        Route::put('/{category}', [\App\Http\Controllers\Api\Category\CategoryController::class, 'update']);
        Route::delete('/{category}', [\App\Http\Controllers\Api\Category\CategoryController::class, 'destroy']);
    });

    Route::group(['prefix' => 'faqs'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Faq\FaqController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Faq\FaqController::class, 'store']);
        Route::get('/{faq}', [\App\Http\Controllers\Api\Faq\FaqController::class, 'show']);
        Route::put('/{faq}', [\App\Http\Controllers\Api\Faq\FaqController::class, 'update']);
        Route::delete('/{faq}', [\App\Http\Controllers\Api\Faq\FaqController::class, 'destroy']);
    });

    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Course\CourseController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Course\CourseController::class, 'store']);
        Route::get('/{course}', [\App\Http\Controllers\Api\Course\CourseController::class, 'show']);
        Route::put('/{course}', [\App\Http\Controllers\Api\Course\CourseController::class, 'update']);
        Route::delete('/{course}', [\App\Http\Controllers\Api\Course\CourseController::class, 'destroy']);
    });

    Route::group(['prefix' => 'lessons'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Lesson\LessonController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Lesson\LessonController::class, 'store']);
        Route::get('/{lesson}', [\App\Http\Controllers\Api\Lesson\LessonController::class, 'show']);
        Route::put('/{lesson}', [\App\Http\Controllers\Api\Lesson\LessonController::class, 'update']);
        Route::delete('/{lesson}', [\App\Http\Controllers\Api\Lesson\LessonController::class, 'destroy']);
        Route::post('/{lesson}/get-test', [\App\Http\Controllers\Api\Lesson\LessonController::class, 'getTestForUser']);
    });

    Route::group(['prefix' => 'tests'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Test\TestController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Test\TestController::class, 'store']);
        Route::get('/{test}', [\App\Http\Controllers\Api\Test\TestController::class, 'show']);
        Route::put('/{test}', [\App\Http\Controllers\Api\Test\TestController::class, 'update']);
        Route::delete('{test}', [\App\Http\Controllers\Api\Test\TestController::class, 'destroy']);
    });

    Route::group(['prefix' => 'questions'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Test\QuestionController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Test\QuestionController::class, 'store']);
        Route::get('/{question}', [\App\Http\Controllers\Api\Test\QuestionController::class, 'show']);
        Route::put('/{question}', [\App\Http\Controllers\Api\Test\QuestionController::class, 'update']);
        Route::delete('{question}', [\App\Http\Controllers\Api\Test\QuestionController::class, 'destroy']);
    });

    Route::group(['prefix' => 'answers'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Test\AnswerController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Test\AnswerController::class, 'store']);
        Route::get('/{answer}', [\App\Http\Controllers\Api\Test\AnswerController::class, 'show']);
        Route::put('/{answer}', [\App\Http\Controllers\Api\Test\AnswerController::class, 'update']);
        Route::delete('/{answer}', [\App\Http\Controllers\Api\Test\AnswerController::class, 'destroy']);
    });

    Route::group(['prefix' => 'variants'], function () {
        Route::get('/', [\App\Http\Controllers\Api\Test\VariantController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\Test\VariantController::class, 'store']);
        Route::get('/{variant}', [\App\Http\Controllers\Api\Test\VariantController::class, 'show']);
        Route::put('/{variant}', [\App\Http\Controllers\Api\Test\VariantController::class, 'update']);
        Route::delete('/{variant}', [\App\Http\Controllers\Api\Test\VariantController::class, 'destroy']);
        Route::get('/{variant}/is-correct', [\App\Http\Controllers\Api\Test\VariantController::class, 'isCorrect']);
    });

    Route::group(['prefix' => 'adata'], function () {
        Route::get('/get-token/{user}',
            [\App\Http\Controllers\Api\AdataDetail\AdataDetailsController::class, 'getFreshAdataToken']);
        Route::get('/fetch-user-data/{token}',
            [\App\Http\Controllers\Api\AdataDetail\AdataDetailsController::class, 'fetchAdataInfoByToken']);
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('get-users-card-details',
                [\App\Http\Controllers\Api\Admin\DashboardController::class, 'getUsersCardDetails']);
            Route::get('get-top-investor', [\App\Http\Controllers\Api\Admin\DashboardController::class, 'getTopInvestor']);
        });

        Route::group(['prefix' => 'startups'], function () {
            Route::get('to-approve', [\App\Http\Controllers\Api\Admin\StartupController::class, 'toApprove']);
            Route::get('to-approve/{startup}', [\App\Http\Controllers\Api\Admin\StartupController::class, 'show']);
            Route::post('to-approve/{startup}/approve', [\App\Http\Controllers\Api\Admin\StartupController::class, 'approve']);
            Route::post('to-approve/{startup}/cancel', [\App\Http\Controllers\Api\Admin\StartupController::class, 'cancel']);
        });
    });

    Route::group(['prefix' => 'user-test-results'], function () {
        Route::get('/', [\App\Http\Controllers\Api\UserTest\UserTestResultController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\UserTest\UserTestResultController::class, 'store']);
        Route::get('/{userTestResult}', [\App\Http\Controllers\Api\UserTest\UserTestResultController::class, 'show']);
    });

    Route::group(['prefix' => 'user-question-results'], function () {
        Route::get('/', [\App\Http\Controllers\Api\UserTest\UserQuestionResultController::class, 'index']);
        Route::get('/{userQuestionResult}', [\App\Http\Controllers\Api\UserTest\UserQuestionResultController::class, 'show']);
        Route::post('/{userQuestionResult}/change-correct', [\App\Http\Controllers\Api\UserTest\UserQuestionResultController::class, 'changeCorrect']);
    });
});


Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});


