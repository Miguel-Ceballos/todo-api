<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->apiResource('authors.categories', CategoryController::class);
Route::middleware('auth:sanctum')->apiResource('authors.tasks', TaskController::class);
Route::apiResource('authors', AuthorController::class);
