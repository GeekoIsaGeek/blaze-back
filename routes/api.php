<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetPairedUserController;
use App\Http\Controllers\GetPairsController;
use App\Http\Controllers\GetUsersController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use App\Http\Resources\InterestResource;
use App\Models\Interest;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load('preference', 'photos', 'interests')->append('age');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('users.register');
    Route::post('/login', 'login')->name('users.login');
    Route::post('/logout', 'logout')->name('users.logout')->middleware(['auth:sanctum']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(PhotoController::class)->group(function () {
        Route::post('/photos/upload', 'uploadPhoto')->name('photos.upload');
        Route::delete('/photos/{id}', 'deletePhoto')->name('photos.delete');
    });

    Route::controller(InteractionController::class)->group(function () {
        Route::post('/user/dislikes/add/{user}', 'dislikeUser')->name('dislike');
        Route::post('/user/likes/add/{user}', 'likeUser')->name('like');
    });

    Route::controller(UserController::class)->group(function () {
        Route::prefix('/user')->group(function () {
            Route::put('/', 'updateUser')->name('user.update');
            Route::put('/gender', 'updateGender')->name('user.update_gender');
            Route::put('/preferences', 'updatePreferences')->name('user.update_preferences');
            Route::delete('/', 'deleteUser')->name('user.delete');

            Route::prefix('/interests')->group(function () {
                Route::post('{interest}/add', 'addInterest')->name('user.add_interest');
                Route::delete('{interest}/delete', 'deleteInterest')->name('user.delete_interest');
            });

            Route::prefix('/languages')->group(function () {
                Route::put('{language}/add', 'addLanguage')->name('user.add_language');
                Route::delete('{language}/delete', 'deleteLanguage')->name('user.delete_language');
            });

        });
    });

    Route::get('/interests', fn () => InterestResource::collection(Interest::all()))->name('interests');
    Route::get('/users', GetUsersController::class)->name('users.get');
    Route::get('/user/matches', GetPairsController::class)->name('user.matches');
    Route::get('/user/matches/{user}', GetPairedUserController::class)->name('user.get_matched_user');
});
