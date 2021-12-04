<?php

use App\Http\Controllers\FoodController;
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

Route::prefix('food')->middleware('auth')->name('food')->group(function () {
    Route::get('/', [FoodController::class, 'index']);
    Route::post('/', [FoodController::class, 'store']);
    Route::post('/{food}', [FoodController::class, 'show'])->name('.show');
    Route::patch('/{food}', [FoodController::class, 'update'])->name('.edit');
    Route::delete('/{food}', [FoodController::class, 'destroy'])->name('.delete');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
