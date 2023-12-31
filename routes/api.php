<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Kontributor;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegistrationEventController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\AnalyticsController;

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
    Route::post('register', [AuthController::class, 'register']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('verify', [AuthController::class, 'verify']);
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

        // News
        Route::get('news/{id}', [NewsController::class, 'show']);
        Route::post('news', [NewsController::class, 'store']);
        Route::put('news/{id}', [NewsController::class, 'update']);
        Route::delete('news/{id}', [NewsController::class, 'destroy']);

        //  Users
        Route::get('/users', [UserController::class, 'indexUsers']);
        Route::get('/users/{id}', [UserController::class, 'showUser']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        // Subscribers
        Route::get('/subscribers', [SubscribeController::class, 'index']);
        Route::delete('/subscribers/{id}', [SubscribeController::class, 'destroy']);
    });


    /**
     * * Kontributor & Admin request Group
     * Kode di sini hanya bisa diakses oleh kontributor dan admin
     */
    Route::middleware([Kontributor::class])->group(function () {


        // Events
        Route::post('events', [EventController::class, 'store']);
        Route::put('events/{id}', [EventController::class, 'update']);
        Route::delete('events/{id}', [EventController::class, 'destroy']);

        // Users delete
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        Route::get('registered/events', [RegistrationEventController::class, 'index']);

        // Analytics
        Route::get('analytics/subscribers', [AnalyticsController::class, 'getSubscribers']);
        Route::get('analytics/events', [AnalyticsController::class, 'getTotalEvents']);
        Route::get('analytics/user-register-events', [AnalyticsController::class, 'getUserRegisterEvents']);
        Route::get('analytics/recently-events', [AnalyticsController::class, 'getRecentEvents']);
        Route::get('analytics/news', [AnalyticsController::class, 'getTotalNews']);
    });


    /**
     * * All request Group
     * Kode di sini bisa diakses oleh semua role user
     */




    // Comments
    Route::get('comments', [CommentController::class, 'index']);
    Route::get('comments/{id}', [CommentController::class, 'show']);
    Route::post('comments', [CommentController::class, 'store']);

    // Registration Events
    Route::get('registered/{id}', [RegistrationEventController::class, 'isRegistered']);
    Route::post('register/event', [RegistrationEventController::class, 'store']);

    // Analytics
});


/**
 * * Public request Group
 * Kode di sini bisa diakses oleh publik
 */


//  get Events public
Route::get('events', [EventController::class, 'index']);
Route::get('events/{id}', [EventController::class, 'show']);
Route::get('events/on/featured', [EventController::class, 'featured']);
Route::get('events/show/{slug}', [EventController::class, 'showBySlug']);

// get News public
Route::get('news', [NewsController::class, 'index']);
Route::get('news/show/{slug}', [NewsController::class, 'showBySlug']);
Route::get('news/on/featured', [NewsController::class, 'featured']);
Route::get('news-recently', [NewsController::class, 'recently']);

// get Categories public
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);

// get Search public
Route::get('search/events', [SearchController::class, 'events']);
Route::get('search/news', [SearchController::class, 'news']);

// get Comments public
Route::get('comments/type/{type}/{id}', [CommentController::class, 'getCommentsByType']);
Route::get('comments/parent/{parent}', [CommentController::class, 'getCommentByParent']);

// subscribe
Route::post('subscribe', [SubscribeController::class, 'store']);
