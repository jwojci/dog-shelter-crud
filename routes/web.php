<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DogController::class, 'index']);
Route::get('/dogs/create', [DogController::class, 'create']);
Route::post('/dogs', [DogController::class, 'store']);
Route::get('/dogs/{id}', [DogController::class, 'show']);
Route::get('/dogs/{id}/edit', [DogController::class, 'edit']);
Route::put('/items/{id}', [DogController::class, 'update']);
Route::delete('/items/{id}', [DogController::class, 'destroy']);
