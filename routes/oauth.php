<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'home']);
Route::get('/about', [AuthController::class, 'about']);
Route::get('/home', [AuthController::class, 'loggedIn']);
Route::get('/login', [AuthController::class, 'login']);
Route::get('/oauth-callback', [AuthController::class, 'callback']);
Route::get('/logout', [AuthController::class, 'logout']);
