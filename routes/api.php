<?php

use App\Http\Controllers\API\DonorController;
use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\RecipientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['controller' => FoodController::class], function () {
    Route::get('/getfood', 'show');
    Route::get('/getfoods', 'index');
    Route::post('/storefood', 'store');
    Route::delete('/destroyfood', 'destroy');
    Route::put('/updatefood', 'update');
});

Route::group(['controller' => DonorController::class], function () {
    Route::get('/getdonors', 'index');
    Route::post('/storedonor', 'store');
    Route::delete('/destroydonor', 'destroy');
    Route::put('/updatedonor', 'update');
});

Route::group(['controller' => RecipientController::class], function () {
    Route::get('/getrecipients', 'index');
    Route::post('/storerecipient', 'store');
    Route::delete('/destroyrecipient', 'destroy');
    Route::put('/updaterecipient', 'update');
});
