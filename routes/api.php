<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BookController;

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

// Book Controller
Route::group(['prefix' => '/v1'], function() {
    // protected route
    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{id}', [BookController::class, 'update']);
        Route::delete('/books/{id}', [BookController::class, 'destroy']);
    });
    // public route
    Route::group([], function() {
        Route::get('/books', [BookController::class, 'index']);
        Route::get('/books/{id}', [BookController::class, 'show']);
        Route::get('/books/search/{title}', [BookController::class, 'search']);
    });
});

// AuthController Admin
Route::group(['prefix' => '/v1'], function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
});


// Member Controller
Route::group(['prefix' => '/v1'], function() {
    // protected route
    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::post('/members', [MemberController::class, 'store']);
        Route::put('/members/{id}', [MemberController::class, 'update']);
        Route::delete('/members/{id}', [MemberController::class, 'destroy']);
    });
    // public route
    Route::group([], function() {
        Route::get('/members', [MemberController::class, 'index']);
        Route::get('/members/{id}', [MemberController::class, 'show']);
        Route::get('/members/search/{title}', [MemberController::class, 'search']);
    });
});
