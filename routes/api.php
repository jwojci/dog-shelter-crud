<?php

use app\Http\Controllers\Api\AuthController;
use app\Http\Controllers\Api\DogController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//CRUD API routes
Route::get('/dogs', [DogController::class, 'index']);
Route::get('/dogs/{id}', [DogController::class, 'show']);
Route::group([], function () {
    Route::post('/dogs', [DogController::class, 'store']);
    Route::put('/dogs/{id}', [DogController::class, 'update']);
    Route::delete('/dogs/{id}', [DogController::class, 'destroy']);
})->middleware('auth:sanctum');

//AUTH API routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
