<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\MemberController;
use App\Http\Controllers\Api\V1\TransactionController;

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

Route::post('/v1/files', [FileController::class, 'store']);

// Book Controller
Route::group(['prefix' => '/v1'], function() {
    // protected route
    // Route::group(['middleware' => ['auth:sanctum']], function() {
    //     Route::get('/books', [BookController::class, 'index']);
    //     Route::get('/books/{id}', [BookController::class, 'show']);
    //     Route::get('/books/search/{title}', [BookController::class, 'search']);
    // });
    // // public route
    Route::group([], function() {
        Route::get('/books', [BookController::class, 'index']);
        Route::get('/books/{id}', [BookController::class, 'show']);
        Route::get('/books/search/{title}', [BookController::class, 'search']);
        Route::put('/books/{id}', [BookController::class, 'update']);
        Route::delete('/books/{id}', [BookController::class, 'destroy']);
        Route::post('/books', [BookController::class, 'store']);
    });
});

// AuthController Admin
Route::group(['prefix' => '/v1/auth'], function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users/{id}', [AuthController::class, 'show']);
    Route::get('/users', [AuthController::class, 'index']);
});


// Member Controller
Route::group(['prefix' => '/v1'], function() {
    // protected route
    Route::group(['middleware' => ['auth:sanctum']], function() {

        Route::put('/members/{id}', [MemberController::class, 'update']);
        Route::delete('/members/{id}', [MemberController::class, 'destroy']);
    });
    // public route
    Route::group([], function() {
        Route::post('/members', [MemberController::class, 'store']);
        Route::get('/members', [MemberController::class, 'index']);
        Route::get('/members/{id}', [MemberController::class, 'show']);
        Route::get('/members/search/{title}', [MemberController::class, 'search']);
    });
});

// Transaction Controller
Route::group(['prefix' => '/v1'], function() {
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
});
