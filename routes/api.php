<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\CommentController;
use App\Http\Controllers\API\V1\FavouriteController;
use App\Http\Controllers\API\V1\Users\AuthController;
use App\Http\Controllers\API\V1\Users\UserController;
use App\Http\Controllers\API\V1\Admin\UserAdminController;
use App\Http\Controllers\API\V1\Admin\OrderAdminController;
use App\Http\Controllers\API\V1\Admin\CommentAdminController;
use App\Http\Controllers\API\V1\Collections\ItemTypeController;
use App\Http\Controllers\API\V1\Seller\SellerRequestController;
use App\Http\Controllers\API\V1\Admin\CollectionAdminController;
use App\Http\Controllers\API\V1\Buyer\CollectionBuyerController;
use App\Http\Controllers\API\V1\Collections\CollectionController;
use App\Http\Controllers\API\V1\Admin\SellerProfileAdminController;
use App\Http\Controllers\API\V1\Buyer\CollectionItemBuyerController;
use App\Http\Controllers\API\V1\Collections\CollectionItemController;
use App\Http\Controllers\API\V1\Seller\SellerCollectionItemController;

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

Route::get('collection-items', [CollectionItemBuyerController::class, 'index']);
Route::get('collection', [CollectionBuyerController::class, 'index']);

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
 * USER/ADMIN/SELLER ROUTES
 */
Route::group(['middleware' => ['auth:api', 'email_verify']], function () {
    Route::resource('users', UserController::class)->only(['update']);

    Route::prefix('users/{user}')->group(function () {
        Route::put('update-password', [UserController::class, 'updatePassword']);
    });

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

        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [OrderAdminController::class, 'index']);
        });

    });

    Route::group(['prefix' => 'users', 'middleware' => ['role:user']], function () {
        Route::post('/seller-verify-request', [SellerRequestController::class, 'store']);
        Route::resource('comments', CommentController::class);
        Route::post('/comments/{comment}/reply', [CommentController::class, 'storeReply']);
    });

    Route::group(['prefix' => 'sellers', 'middleware' => ['role:seller']], function () {

        Route::group(['prefix' => 'collections/{collection}'], function () {
            Route::put('/collection-items/{collectionItem}', [SellerCollectionItemController::class, 'update']);
        });

    });

    Route::group(['middleware' => ['role:admin|user|seller']], function () {
        Route::get('/my_favorites', [FavouriteController::class, 'myFavorites']);
        Route::resource('collections', CollectionController::class);

        Route::group(['prefix' => 'collections/{collection}'], function () {
            Route::resource('collection-items', CollectionItemController::class);
            Route::post('/favourite/{collectionItem}', [FavouriteController::class, 'favourite']);
            Route::post('/unfavourite/{collectionItem}', [FavouriteController::class, 'unFavourite']);
        });

        Route::group(['prefix' => 'orders'], function () {
            Route::post('/checkout', [OrderController::class, 'store']);
            Route::get('/pending', [OrderController::class, 'index']);
            Route::put('{order}/complete', [OrderController::class, 'update']);
        });

    });

});
