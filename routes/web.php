<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\AuthController;

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
Route::get('/', function () {
    return view('welcome');
});

// Route::resource('tasks', TaskController::class)->except(['show', 'destroy']);
// Route::middleware(['auth:web'])->group(function () {
//     Route::resource('tasks', TaskController::class);
// });
// // Trashed, restore, and force delete routes
// Route::get('tasks/trashed', [TaskController::class, 'trashed'])->name('tasks.trashed');
// Route::post('tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
// Route::delete('tasks/{id}/force-delete', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');

// // Auth Routes
// Route::get('login', [AuthController::class, 'loginForm'])->name('login');
// Route::post('login', [AuthController::class, 'login'])->name('login.submit');
// Route::get('register', [AuthController::class, 'registerForm'])->name('register');
// Route::post('register', [AuthController::class, 'register'])->name('register.submit');
// Route::post('logout', [AuthController::class, 'logout'])->name('logout');
