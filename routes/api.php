<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\AuthController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\API\V1\CommentController;
use App\Http\Controllers\API\V1\Admin\UserAdminController;
use App\Http\Controllers\API\V1\Admin\CommentAdminController;
use App\Http\Controllers\API\V1\Collections\ItemTypeController;
use App\Http\Controllers\API\V1\Seller\SellerRequestController;
use App\Http\Controllers\API\V1\Admin\CollectionAdminController;
use App\Http\Controllers\API\V1\Collections\CollectionController;
use App\Http\Controllers\API\V1\Admin\SellerProfileAdminController;
use App\Http\Controllers\API\V1\Collections\CollectionItemController;
use App\Http\Controllers\PaymentController;

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
Route::group(['middleware' => ['auth:api', 'email_verify']], function () {
    Route::prefix('users/{user}')->group(function () {
        Route::put('update-password', [UserController::class, 'updatePassword']);
    });
    Route::resource('users', UserController::class)->only(['update']);

    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
        Route::resource('collection-item-types', ItemTypeController::class);

        Route::group(['prefix' => 'sellers'], function () {
            Route::get('/pending', [SellerProfileAdminController::class, 'index']);
            Route::put('/action/{seller_profile}', [SellerProfileAdminController::class, 'update']);
            Route::get('/approved', [SellerProfileAdminController::class, 'approved']);
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserAdminController::class, 'index']);

        });

        Route::group(['prefix' => 'comments'], function () {
            Route::get('/pending', [CommentAdminController::class, 'index']);
            Route::put('/action/{comment}', [CommentAdminController::class, 'update']);
            Route::get('/approved', [CommentAdminController::class, 'approved']);
        });

        Route::group(['prefix' => 'collections'], function () {
            Route::get('/pending', [CollectionAdminController::class, 'index']);
            Route::put('/action/{collection}', [CollectionAdminController::class, 'update']);
            Route::get('/approved', [CollectionAdminController::class, 'approved']);
        });
    });

    Route::group(['middleware' => ['role:admin|user|seller']], function () {
        Route::group(['prefix' => 'collections/{collection}'], function () {
            Route::resource('collection-items', CollectionItemController::class);
        });
        Route::resource('collections', CollectionController::class);
    });

    Route::group(['prefix' => 'users', 'middleware' => ['role:user']], function () {
        Route::post('/seller-verify-request', [SellerRequestController::class, 'store']);
        Route::resource('comments', CommentController::class);
        Route::post('/comments/{comment}/reply', [CommentController::class, 'storeReply']);

    });
    Route::group(['prefix' => 'users', 'middleware' => ['role:user']], function () {
        Route::post('/seller-verify-request', [SellerRequestController::class, 'store']);
        Route::resource('comments', CommentController::class);
        Route::post('/comments/{comment}/reply', [CommentController::class, 'storeReply']);
    });
    Route::get('collection-item/sales/details', [PaymentController::class, 'salesDetails']);
});
Route::post('collection-item/buy', [PaymentController::class, 'store']);
