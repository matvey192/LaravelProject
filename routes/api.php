<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/{id}', [ProjectController::class, 'show']);
    Route::post('/', [ProjectController::class, 'store']);
    Route::put('/{id}', [ProjectController::class, 'update']);
    Route::delete('/{id}', [ProjectController::class, 'destroy']);
    
    // Доп. задание — проверка доступности сайта
    Route::get('/{id}/check', [ProjectController::class, 'check']);
});
