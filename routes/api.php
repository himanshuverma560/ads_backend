<?php

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

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CityController;

Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::get('/profiles', [ProfileController::class, 'index']);
Route::get('/profiles/{profile}', [ProfileController::class, 'show']);
Route::get('/cities', [CityController::class, 'index']);
Route::middleware('jwt')->group(function () {
    Route::post('/profiles', [ProfileController::class, 'store']);
    Route::post('/profiles/{profile}', [ProfileController::class, 'update']);
});
