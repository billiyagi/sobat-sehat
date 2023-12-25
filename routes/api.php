<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Kontributor;
use App\Http\Controllers\EventController;
use App\Models\User;

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

/**
 * * Authenticate request Group
 * Route untuk request yang membutuhkan autentikasi
 */
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);
});




/**
 * * Authenticated request Group
 * Kode di sini hanya bisa diakses oleh user yang sudah login
 */
Route::middleware('auth:api')->group(function () {

    /**
     * * Admin request Group
     * Kode di sini hanya bisa diakses oleh admin
     */
    Route::middleware([Admin::class])->group(function () {
        // Route
    });


    /**
     * * Kontributor & Admin request Group
     * Kode di sini hanya bisa diakses oleh kontributor dan admin
     */
    Route::middleware([Kontributor::class])->group(function () {
        Route::get('events', [EventController::class, 'index']);
        Route::get('events/{id}', [EventController::class, 'show']);
        Route::post('events', [EventController::class, 'store']);
        Route::put('events/{id}', [EventController::class, 'update']);
        Route::delete('events/{id}', [EventController::class, 'destroy']);
        
        
        
    });


    /**
     * * All request Group
     * Kode di sini bisa diakses oleh semua role user
     */
    Route::middleware('auth:sanctum')->group(function (){
        Route::get('/users', [UserController::class, 'indexUsers']);
        Route::get('/users{id}', [UserController::class, 'showUsers']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users{id}', [UserController::class, 'update']);
        Route::delete('/users{id}', [UserController::class, 'destroy']);
    });
  
});
