<?php
use App\Http\Controllers\WikiController;
use Illuminate\Support\Facades\Route;

    Route::get('/wiki/add/{term}', [WikiController::class, 'add']);
    Route::get('/wiki/update/{termId}', [WikiController::class, 'update']);
    Route::get('/wiki/view/{termId}', [WikiController::class, 'view']);
