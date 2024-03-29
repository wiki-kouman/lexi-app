<?php
use App\Http\Controllers\WikiController;
use Illuminate\Support\Facades\Route;

Route::get('/wiki/add/{termId}', [WikiController::class, 'add']);
Route::get('/wiki/view/{termId}', [WikiController::class, 'view']);
