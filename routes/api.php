<?php

use App\Http\Controllers\API\V1\Collections\CollectionController;
use App\Http\Controllers\API\V1\Collections\CollectionItemController;
use App\Http\Controllers\API\V1\Collections\ItemTypeController;
use App\Http\Controllers\API\V1\Seller\SellerRequestController;
use App\Http\Controllers\Users\AuthController;
use App\Http\Controllers\Users\UserController;
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

/*
 * AUTH ROUTES
 */
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('signup/activate/{token}', [AuthController::class, 'userActivate'])->name('token-activation');
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::prefix('forget-password')->group(function () {
        Route::post('', [AuthController::class, 'forget']);
        Route::get('{token}', [AuthController::class, 'reset']);
        Route::post('confirm', [AuthController::class, 'confirm']);
    });
});

/*
 * USER ROUTES
 */
Route::group(['middleware' => ['auth:api','email_verify']], function () {
    Route::prefix('users/{user}')->group(function () {
        Route::put('update-password', [UserController::class, 'updatePassword']);
    });
    Route::resource('users', UserController::class)->only(['update']);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('collection-item-type', ItemTypeController::class);
        Route::get('/get-verify-request', [SellerRequestController::class, 'index']);
        Route::put('/approve-seller-request/{id}', [SellerRequestController::class, 'update']);

    });

    Route::group(['middleware' => ['role:admin|user|seller']], function () {
        Route::resource('collection', CollectionController::class);
        Route::resource('collection-item', CollectionItemController::class);
    });

    Route::group(['middleware' => ['role:user']], function () {
        Route::post('/seller-verify-request', [SellerRequestController::class, 'store']);
    });
});
