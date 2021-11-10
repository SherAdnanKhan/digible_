<?php

use App\Http\Controllers\WyreTestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/docs', function () {
    return view('docs.doc');
});

Route::get('/create-account', [WyreTestController::class, 'createAccount']);
Route::get('/create-wallet', [WyreTestController::class, 'createWallet']);
Route::get('/get-wallet', [WyreTestController::class, 'getWallet']);
