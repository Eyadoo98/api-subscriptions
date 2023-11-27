<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::post('createUser', 'createUser');
    Route::post('loginUser', 'loginUser');
//    Route::middleware(['auth:sanctum','api_rate_limiting'])->group(function () {
//        // Your API routes
//        Route::get(
//            '/users',
//            function () {
//                return \App\Models\User::all();
//            }
//        );
//    });
});

//Route::middleware(['check.api.key','auth:sanctum'])->group(function () {//,'throttle.api:10,1'
//    Route::get(
//        '/users',
//        function () {
//            return \App\Models\User::all();
//        }
//    );
//});

//Route::middleware(['auth:sanctum'])->group(function () {
//    $userSubscriptionType = auth()->user()->subscription_type ?? 'free';
//    if ($userSubscriptionType == 'free') {
//        Route::middleware(['throttle:freeApiMinutelyThrottle', 'throttle:freeApiHourlyThrottle', 'throttle:freeApiDailyThrottle'])->group(function () {
//            Route::get('/users', [App\Http\Controllers\GetAllUsersController::class, 'index']);
//            //            Route::get('/users', function () {
////                return \App\Models\User::all();
////            });
//        });
//    }
//    if ($userSubscriptionType == 'paid') {
//        Route::middleware(['throttle:paidApiMinutelyThrottle', 'throttle:paidApiHourlyThrottle', 'throttle:paidApiDailyThrottle'])->group(function () {
//            Route::get('/users', [App\Http\Controllers\GetAllUsersController::class, 'index']);
//            //            Route::get('/users', function () {
////                return \App\Models\User::all();
////            });
//        });
//    }
//});


//free api
Route::middleware(['throttle:freeApiMinutelyThrottle', 'throttle:freeApiHourlyThrottle', 'throttle:freeApiDailyThrottle'])->group(function () {//'auth:sanctum',
    Route::get('/freeVersion/users', [App\Http\Controllers\GetAllUsersController::class, 'freeIndex']);
});

//paid api
Route::middleware(['throttle:paidApiMinutelyThrottle', 'throttle:paidApiHourlyThrottle', 'throttle:paidApiDailyThrottle'])->group(function () {//'auth:sanctum',
    Route::get('/paidVersion/users', [App\Http\Controllers\GetAllUsersController::class, 'paidIndex']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/generate-api-key', [\App\Http\Controllers\ApiKeyController::class, 'generateApiKey']);
    Route::put('/update-generate-api-key', [\App\Http\Controllers\ApiKeyController::class, 'updateGenerateApiKey']);
});