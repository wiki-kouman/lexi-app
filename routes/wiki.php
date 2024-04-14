<?php
use App\Http\Controllers\WikiController;
use Illuminate\Support\Facades\Route;

    Route::get('/wiki/search', [WikiController::class, 'search']);
    Route::get('/wiki/add/{term}', [WikiController::class, 'preAdd']);
    Route::get('/wiki/update/{termId}', [WikiController::class, 'preUpdate']);
    Route::get('/wiki/view/{termId}', [WikiController::class, 'view']);
    Route::post('/wiki/preview', [WikiController::class, 'preview']);
    Route::post('/wiki/create', [WikiController::class, 'add']);
    Route::post('/wiki/update', [WikiController::class, 'update']);
