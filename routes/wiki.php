<?php

	use App\Http\Controllers\SignatureController;
	use App\Http\Controllers\WikiController;
	use Illuminate\Support\Facades\Route;

	Route::get('/wiki/search', [WikiController::class, 'search']);
	Route::get('/wiki/view/{termId}', [WikiController::class, 'view']);
	Route::get('/wiki/add/{term}', [WikiController::class, 'preAdd']);
	Route::get('/wiki/sign', [SignatureController::class, 'preSign']);
	Route::post('/wiki/sign/confirm', [SignatureController::class, 'sign']);
	Route::get('/wiki/update/{termId}', [WikiController::class, 'preUpdate']);
	Route::post('/wiki/preview', [WikiController::class, 'preview']);
	Route::post('/wiki/add', [WikiController::class, 'add']);
	Route::post('/wiki/update/{termId}', [WikiController::class, 'update']);
