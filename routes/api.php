<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\MentorController;
use App\Http\Controllers\Api\OverviewController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:login');

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/overview', OverviewController::class);

    Route::prefix('tasks')->group(function (): void {
        Route::get('/', [TaskController::class, 'index']);
        Route::get('/{task}', [TaskController::class, 'show']);
        Route::get('/{task}/steps', [TaskController::class, 'steps']);
    });

    Route::prefix('mentors')->group(function (): void {
        Route::get('/', [MentorController::class, 'index']);
        Route::get('/recent', [MentorController::class, 'recent']);
        Route::get('/{mentor}', [MentorController::class, 'show']);
        Route::post('/{mentor}/follow', [MentorController::class, 'follow']);
        Route::delete('/{mentor}/follow', [MentorController::class, 'unfollow']);
    });

    Route::prefix('conversations')->group(function (): void {
        Route::get('/', [ConversationController::class, 'index']);
        Route::get('/{conversation}/messages', [ConversationController::class, 'messages']);
        Route::post('/{conversation}/messages', [ConversationController::class, 'send']);
    });

    Route::get('/settings', [SettingsController::class, 'show']);
    Route::put('/settings', [SettingsController::class, 'update']);
});
