<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('tasks', TaskController::class);
});

