<?php

use Illuminate\Support\Facades\Route;
use Braintree\Gateway as Gateway;


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

Route::get('/', function () {

    $gateway = new Gateway([
        'environment' => 'sandbox',
        'merchantId' => 'fs4whkzypxsqc7xn',
        'publicKey' => '97tp4wjp72rh7zh9',
        'privateKey' => '7977e7b9a05118f5981ff44adf7b0cf1'
    ]);

    $clientToken = $gateway->clientToken()->generate();
    // return $clientToken;
    return view('welcome', compact('clientToken'));
})->name('home');

Route::post('/payment', 'PaymentController@pay')->name('payment');
