<?php
use App\Http\Controllers\WikiController;
use Illuminate\Support\Facades\Route;

    Route::get('/wiki/search', [WikiController::class, 'search']);
    Route::get('/wiki/add/{term}', [WikiController::class, 'add']);
    Route::get('/wiki/update/{termId}', [WikiController::class, 'update']);
    Route::get('/wiki/view/{termId}', [WikiController::class, 'view']);
    Route::post('/wiki/preview', [WikiController::class, 'preview']);
    Route::post('/wiki/create', [WikiController::class, 'create']);
