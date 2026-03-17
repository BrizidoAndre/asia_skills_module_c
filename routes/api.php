<?php

use App\Base\ApiResponse;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

// public routes (no auth required)

//auth related routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

//albums related routes
Route::get('albums', [AlbumController::class, 'index']);
Route::get('albums/{album}', [AlbumController::class, 'show'])->missing(fn() => ApiResponse::errorResponse(404, 'Not found'));
//todo missing this
Route::get('albums/{album}/cover', [AlbumController::class, 'cover'])->missing(fn() => ApiResponse::errorResponse(404, 'Cover Not Found'));
Route::get('albums/{album}/songs', [AlbumController::class, 'songs'])->missing(fn() => ApiResponse::errorResponse(404, 'Not Found'));
//songs related routes
Route::get('songs', [SongController::class, 'index']);
//todo missing this as well
Route::get('songs/{song}/cover', [SongController::class, 'cover'])->missing(fn() => ApiResponse::errorResponse(404, 'Cover Not Found'));

// authentication routes
Route::middleware(AuthMiddleware::class)->group(function () {
    //auth related routes
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('songs/{song}', [SongController::class, 'show'])->missing(fn() => ApiResponse::errorResponse(404, 'Not found'));
    Route::get('statistics', [SongController::class, 'statistics']);
//    admin related routes
    Route::middleware(IsAdminMiddleware::class)->group(function () {
//        users related actions
        Route::get('users', [UserController::class, 'index']);
        Route::put('users/{user}', [UserController::class, 'update']);
        Route::put('users/{user}/ban', [UserController::class, 'ban']);
        Route::put('users/{user}/unban', [UserController::class, 'unban']);

//        album crud
        Route::post('albums', [AlbumController::class, 'store']);
        Route::put('albums/{album}', [AlbumController::class, 'update']);
        Route::delete('albums/{album}', [AlbumController::class, 'delete']);
        Route::post('albums/{album}/songs', [AlbumController::class, 'storeSong']);
        Route::put('albums/{album}/songs', [AlbumController::class, 'storeOrder']);
//        song crud
        Route::post('albums/{album}/songs/{song}', [SongController::class, 'update']);
        Route::delete('albums/{album}/songs/{song}', [SongController::class, 'delete']);
    });
});
