<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GetUsersController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use App\Http\Resources\InterestResource;
use App\Models\Interest;
use App\Models\User;

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
        Route::get('/users/{user}/pfp', 'getProfilePic')->name('user.get_profile_pic');
    });

    Route::controller(PairController::class)->group(function () {
        Route::prefix('/user/matches')->group(function () {
            Route::delete('/{user}', 'destroy')->name('user.delete_matched_user');
            Route::get('/{user}', 'show')->name('user.get_matched_user');
            Route::get('/', 'index')->name('user.matches');
        });
    });

    Route::controller(ChatController::class)->group(function () {
        Route::get('/chats/previews', 'getPreviews')->name('chats.get_previews');
        Route::post('/chats/{user}', 'createOrGetIfExists')->name('chats.create_or_get');
        Route::get('/chats/{chat}/messages', 'getChatMessages')->name('chats.get_messages');
    });


    Route::controller(MessageController::class)->group(function () {
        Route::post('/messages', 'store')->name('messages.store');
    });

    Route::get('/interests', fn () => InterestResource::collection(Interest::all()))->name('interests');
    Route::get('/users', GetUsersController::class)->name('users.get');
});
