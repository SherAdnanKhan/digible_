<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\AuthController;
use App\Http\Controllers\Users\UserController;

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

/*
 * AUTH ROUTES
 */
Route::prefix('auth')->group(function () {
    Route::post('register' , [AuthController::class, 'register']);
    Route::post('login' , [AuthController::class, 'login']);
    Route::get('signup/activate/{token}' , [AuthController::class, 'userActivate'])->name('token-activation');
    Route::get('logout' , [AuthController::class, 'logout'])->middleware('auth:api');
    Route::prefix('forget-password')->group(function(){
        Route::post('' , [AuthController::class, 'forget']);
        Route::post('{token}' , [AuthController::class, 'reset']);
        Route::post('confirm' , [AuthController::class, 'confirm']);
    });
});

/*
 * USER ROUTES
 */
Route::group(['middleware' => ['auth:api', 'is_user']], function () {
    Route::prefix('users/{user}')->group(function () {
        Route::put('update-password' , [UserController::class, 'updatePassword']);
    });
    
    Route::resource('users', UserController::class)->only(['update']);
});