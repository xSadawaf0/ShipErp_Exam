<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataProviderController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (){
        Route::get('loginData', [AuthController::class, 'index']);

        
    });

    Route::post('add', [DataProviderController::class, 'store']);
    Route::get('list', [DataProviderController::class, 'index']);
    Route::get('item/{id}', [DataProviderController::class, 'view']);
    Route::put('item/{id}', [DataProviderController::class, 'update']);
    Route::delete('item/{id}', [DataProviderController::class, 'destroy']);
});
