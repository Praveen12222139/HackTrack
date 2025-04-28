<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HackathonController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\TeamController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Hackathon routes
    Route::get('/hackathons', [HackathonController::class, 'index']);
    Route::get('/hackathons/{hackathon}', [HackathonController::class, 'show']);
    Route::get('/hackathons/{hackathon}/statistics', [HackathonController::class, 'statistics']);

    // Application routes
    Route::get('/hackathons/{hackathon}/applications', [ApplicationController::class, 'index']);
    Route::post('/hackathons/{hackathon}/applications', [ApplicationController::class, 'store']);
    Route::get('/applications/{application}', [ApplicationController::class, 'show']);
    Route::patch('/applications/{application}', [ApplicationController::class, 'update']);
    Route::post('/applications/{application}/check-in', [ApplicationController::class, 'checkIn']);

    // Team routes
    Route::get('/teams', [TeamController::class, 'index']);
    Route::post('/teams', [TeamController::class, 'store']);
    Route::get('/teams/{team}', [TeamController::class, 'show']);
    Route::patch('/teams/{team}', [TeamController::class, 'update']);
    Route::delete('/teams/{team}', [TeamController::class, 'destroy']);
    Route::post('/teams/{team}/join', [TeamController::class, 'join']);
    Route::post('/teams/{team}/leave', [TeamController::class, 'leave']);

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::post('/hackathons', [HackathonController::class, 'store']);
        Route::patch('/hackathons/{hackathon}', [HackathonController::class, 'update']);
        Route::delete('/hackathons/{hackathon}', [HackathonController::class, 'destroy']);
    });
});
