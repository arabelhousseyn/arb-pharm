<?php

use App\Http\Controllers\{Api\V1\AdminController,
    Api\V1\AdminPanelApiController,
    Api\V1\checkAppVersionController,
    Api\V1\CheckbookController,
    Api\V1\LoginController,
    Api\V1\ProductController,
    Api\V1\RatingController,
    Api\V1\RegisterController,
    Api\V1\RequestEstimateController,
    Api\V1\SearchController,
    Api\V1\UserController,
    Api\V1\UserProfileController};
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



//// mobile api
Route::prefix('mobile')->group(function(){
    Route::get('/version',[checkAppVersionController::class,'mobile']);
    /// register
    Route::post('/register',[RegisterController::class,'register']);
    /// login
    Route::post('/login',[LoginController::class,'auth']);

    Route::apiResource('checkbook',CheckbookController::class);


    Route::group(['middleware' => 'auth:sanctum'],function(){

        Route::prefix('user')->group(function(){
            Route::get('notification',[UserController::class,'notifications']);
            Route::get('count_notification',[UserController::class,'count_notification']);
        });

        Route::prefix('product')->group(function(){
            Route::post('rate',RatingController::class);
        });

        Route::prefix('request_estimate')->group(function (){
            Route::post('store_offer',[RequestEstimateController::class,'store_offer']);
            Route::get('get_offers/{request_estimate_id}',[RequestEstimateController::class,'get_offers'])->whereNumber('request_estimate_id');
        });

        Route::get('search',SearchController::class);

        Route::get('/insertCode/{code?}',[UserProfileController::class,'insertCode'])->whereNumber('code');
        Route::get('/favoritesProducts',[UserProfileController::class,'favoritesProducts']);
        Route::get('/profile/{user_id?}',[UserProfileController::class,'profile'])->whereNumber('user_id');
        Route::get('/getMyProducts/{user_id?}',[UserProfileController::class,'getMyProducts'])->whereNumber('user_id');
        Route::get('/getMyRequest/{user_id?}',[UserProfileController::class,'getMyRequest'])->whereNumber('user_id');
        Route::apiResources([
            'user'=>UserProfileController::class,
            'product'=>ProductController::class,
            'request_estimate' => RequestEstimateController::class
        ]);
    });
});

/// dasbhaord api

Route::prefix('dashboard')->group(function(){

    Route::group(['middleware' => 'auth:sanctum'],function(){
        //
        Route::get('/getInformations',[AdminPanelApiController::class,'getInformations']);
        Route::get('/graph',[AdminPanelApiController::class,'graph']);
        // admin
        Route::prefix('/admin')->group(function(){
            Route::put('/changePassword/{admin}',[AdminController::class,'changePassword']);
            Route::get('/notification',[AdminController::class,'notification']);
        });
        // user
        Route::prefix('/user')->group(function() {
            Route::put('/activateUser/{user}',[UserController::class,'activateUser']);
            Route::put('/deactivateUser/{user}',[UserController::class,'deactivateUser']);
            Route::put('/changePassword/{user}',[UserController::class,'changePassword']);
            Route::put('/updateProfileUser/{user}',[UserController::class,'updateProfileUser']);
            Route::get('/profileInfo/{user}',[UserController::class,'profileInfo']);
            Route::get('/subscribe-history/{user}',[UserController::class,'subscribeHistory']);
        });
        // product
        Route::prefix('/product')->group(function(){
            Route::get('/getProductsByUser/{user}',[ProductController::class,'getProductsByUser']);
            Route::get('/getFavoritsProductsUser/{user}',[ProductController::class,'getFavoritsProductsUser']);
            Route::get('/getAllProducts',[ProductController::class,'getAllProducts']);
        });
        // request estimate
        Route::prefix('/request')->group(function(){
            Route::get('/getRequestEstimateByUser/{user}',[RequestEstimateController::class,'getRequestEstimateByUser']);
            Route::get('/getAllRequestsEstimate',[RequestEstimateController::class,'getAllRequestsEstimate']);
        });
        Route::apiResources([
            'admin' => AdminController::class,
            'user' => UserController::class,
            'product' => ProductController::class,
            'request' => RequestEstimateController::class,
            'checkbook' => CheckbookController::class,
        ]);
    });
});
