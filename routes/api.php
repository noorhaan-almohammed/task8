<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\AuthController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::get('profile', 'profile');
    Route::get('logout', 'logout');
    Route::get('refresh', 'refresh');

});
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('tasks', TaskController::class);
});

Route::middleware(['auth:api'])->put('task/{task}/status',[TaskController::class, 'updateStatus']);
