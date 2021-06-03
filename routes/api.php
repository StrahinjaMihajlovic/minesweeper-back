<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
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

//routes for store and items
Route::group([
    'prefix' => 'store',
    'middleware' => [
        'api',
        'jwt'
    ]
], function () {
    Route::put('item', [StoreController::class, 'store']);

    Route::get('item/{item}', [StoreController::class, 'show'])->name('item.show');
    Route::delete('item/{item}', [StoreController::class, 'destroy']);
    Route::patch('item/{item}', [StoreController::class, 'update'])->name('item.update');
});

Route::group([

    'middleware' => 'api',

], function ($router) {
    //routes for authentification
    Route::post('login', [AuthController::class, 'login']);
    Route::post('test', [AuthController::class, 'test'])->middleware('jwt');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
});





