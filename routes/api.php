<?php

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

/*
 * AUTH ROUTES
 */
Route::prefix('auth')->group(function () {
    Route::post('register', 'Users\AuthController@register');
    Route::post('login', 'Users\AuthController@login');
    Route::get('signup/activate/{token}', 'Users\AuthController@userActivate')->name('token-activation');
    Route::get('logout', 'Users\AuthController@logout')->middleware('auth:api');
    Route::prefix('forget-password')->group(function(){
        Route::post('', 'Users\AuthController@forget');
        Route::get('{token}', 'Users\AuthController@reset');
        Route::post('confirm', 'Users\AuthController@confirm');
    });
});

/*
 * USER ROUTES
 */
Route::group(['middleware' => ['auth:api', 'is_user']], function () {
    Route::prefix('users/{user}')->group(function () {
        Route::put('update-password', 'Users\UserController@updatePassword');
    });
    
    Route::resource('users', 'Users\UserController')->only(['update']);
});