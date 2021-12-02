<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    RegisterController,
    UserProfileController,
    ProductController,
    RequestEstimateController,
    checkAppVersionController,
    AdminPanelApiController,
    AdminController,
    UserController
};

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
    Route::get('/version',[checkAppVersionController::class,'index']);
    /// register
    Route::post('/register',[RegisterController::class,'register']);
    /// login
    Route::post('/login',[LoginController::class,'auth']);


    Route::group(['middleware' => 'auth:sanctum'],function(){

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
        // change password admin
        Route::put('/changePassword/{admin}',[AdminController::class,'changePassword']);
        // user
        Route::prefix('/user')->group(function() {
            Route::put('/activateUser/{user}',[UserController::class,'activateUser']);
            Route::put('/deactivateUser/{user}',[UserController::class,'deactivateUser']);
            Route::put('/changePassword/{user}',[UserController::class,'changePassword']);
            Route::put('/updateProfileUser/{user}',[UserController::class,'updateProfileUser']);
            Route::get('/profileInfo/{user}',[UserController::class,'profileInfo']);
        });
        Route::apiResources([
            'admin' => AdminController::class,
            'user' => UserController::class,
        ]);
    });
});
