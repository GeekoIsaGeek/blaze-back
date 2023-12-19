<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;

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
    Route::post('/register', 'register')->name('users.register');
    Route::post('/login', 'login')->name('users.login');
    Route::post('/logout', 'logout')->name('users.logout');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(PhotoController::class)->group(function () {
        Route::post('/photos/upload', 'uploadPhoto')->name('photos.upload');
        Route::delete('/photos/{id}', 'deletePhoto')->name('photos.delete');
    });
});
