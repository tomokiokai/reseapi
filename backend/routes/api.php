<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\GenresController;

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'users'], function() {
        Route::post('registration', [UsersController::class, 'registration']);
        Route::post('login', [UsersController::class, 'login']);
        Route::post('logout', [UsersController::class, 'logout']);
        Route::get('{user_id}', [UsersController::class, 'getUser']);
    });
    Route::group(['prefix' => 'shops'], function() {
        Route::get('', [ShopsController::class, 'getShops']);
        Route::get('{shop_id}', [ShopsController::class, 'getShop']);
        Route::post('{shop_id}/likes', [ShopsController::class, 'postLike']);
        Route::delete('{shop_id}/likes/{like_id}', [ShopsController::class, 'deleteLike']);
        Route::post('{shop_id}/reservations', [ShopsController::class, 'postReservation']);
        Route::delete('{shop_id}/reservations/{reservation_id}', [ShopsController::class, 'deleteReservation']);
    });
    Route::get('areas', [AreasController::class, 'getAreas']);
    Route::get('genres', [GenresController::class, 'getGenres']);
});

