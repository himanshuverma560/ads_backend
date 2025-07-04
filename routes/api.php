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
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;

Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::get('/profiles', [ProfileController::class, 'index']);
Route::get('/profiles/{profile}', [ProfileController::class, 'show']);
Route::post('/profiles/{profile}/views', [ProfileController::class, 'storeView']);
Route::get('/cities', [CityController::class, 'all']);
Route::get('/cities/{id}', [CityController::class, 'index']);
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/states/{id}', [StateController::class, 'index']);
Route::middleware('jwt')->group(function () {
    Route::post('/profiles', [ProfileController::class, 'store']);
    Route::post('/profiles/{profile}', [ProfileController::class, 'update']);
    Route::post('/countries', [CountryController::class, 'store']);
    Route::post('/countries/{country}', [CountryController::class, 'update']);
    Route::post('/states', [StateController::class, 'store']);
    Route::post('/states/{state}', [StateController::class, 'update']);
    Route::post('/cities', [CityController::class, 'store']);
    Route::post('/cities/{city}', [CityController::class, 'update']);
});
