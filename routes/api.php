<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ AuthController::class, 'login' ]);
Route::middleware('auth:sanctum')->post('logout', [ AuthController::class, 'logout' ]);
Route::post('/register', [ AuthController::class, 'register' ]);
Route::middleware('auth:sanctum')->get('user', [ UserController::class, 'show' ])->name('user.show');
