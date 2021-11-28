<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    RegisterController,
    UserProfileController,
    ProductController
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
  /// register
Route::post('/register',[RegisterController::class,'register']);
  /// login
Route::post('/login',[LoginController::class,'auth']);


Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('/insertCode/{code?}',[UserProfileController::class,'insertCode']);
    Route::get('/favoritesProducts',[UserProfileController::class,'favoritesProducts']);
    Route::apiResources([
        'user'=>UserProfileController::class,
        'product'=>ProductController::class
    ]);
});
