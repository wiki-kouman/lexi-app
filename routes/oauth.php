<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'loggedout']);
Route::get('/home', [AuthController::class, 'home']);
Route::get('/login', [AuthController::class, 'login']);
Route::get('/oauth-callback', [AuthController::class, 'callback']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/about', [AuthController::class, 'about']);
