<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

// Public Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Categories (Lab 04)
    Route::apiResource('categories', CategoryController::class)->only(['index', 'store', 'show', 'destroy']);

    // Tasks (Lab 02, 03 & 04 Bonus)
    Route::patch('tasks/{task}/complete', [TaskController::class, 'complete']);
    Route::apiResource('tasks', TaskController::class);
});
