<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->apiResource('categories', CategoryController::class);
Route::middleware('auth:sanctum')->apiResource('tasks', TaskController::class);
Route::apiResource('authors', AuthorController::class);
