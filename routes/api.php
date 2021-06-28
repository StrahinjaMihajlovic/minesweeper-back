<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\GameController;
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

    ]
], function () {
    Route::post('item', [StoreController::class, 'store']);
    Route::get('/', [StoreController::class, 'index']);
    Route::get('item/{item}', [StoreController::class, 'show'])->name('item.show');
    Route::delete('item/{item}', [StoreController::class, 'destroy']);
    Route::put('item/{item}', [StoreController::class, 'update'])->name('item.update');
    Route::post('category', [StoreController::class, 'createCategory'])->name('category.create');
    Route::get('category', [StoreController::class, 'listCategories'])->name('category.list');
});

Route::group([

    'middleware' => 'api',

], function () {
    //routes for authentification
    Route::post('login', [AuthController::class, 'login']);
    Route::get('test', [AuthController::class, 'test'])->middleware('jwt');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt');
    Route::post('register', [AuthController::class, 'register']);
});

Route::group([
    'prefix' => 'game',
    'middleware' => [
        'api',
    ]
], function () {
    Route::post('generate', [GameController::class, 'generateGame'])->name('game.generator');
});


