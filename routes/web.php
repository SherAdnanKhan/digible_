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

Route::get('/checkout', function () {
    return view('payment.wyre');
});

Route::get('/creditcard', function () {
    $result = [];
    $result[0] = ["order_id" => 140, "collection_item_id" => 6, "quantity" => 5];
    $result[1] = [
        "order_id" => 141,
        "collection_item_id" => 7,
        "quantity" => 4,
    ];
    $result[2] = [
        "order_id" => 142,
        "collection_item_id" => 8,
        "quantity" => 1,
    ];
    $result["reservation"] = "WHNH6RJACLCBURCXHV4F";
    return view('payment.creditcard')->with(compact('result'));
});

Route::get('/sdk', function () {
    return view('payment.sdk');
});

Route::get('/create-account', [WyreTestController::class, 'createAccount']);

Route::get('/create-wallet', [WyreTestController::class, 'createWallet']);
Route::get('/get-wallet', [WyreTestController::class, 'getWallet']);
Route::get('/swap', [WyreTestController::class, 'swap']);
Route::get('/transfer', [WyreTestController::class, 'transfer']);
Route::get('/check-out', [WyreTestController::class, 'transaction']);
