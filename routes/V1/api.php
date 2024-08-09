<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CategoryTasksController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('categories.tasks', CategoryTasksController::class);
    Route::apiResource('tasks', TaskController::class);
});

