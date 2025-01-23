<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('category')->controller(\App\Http\Controllers\Category\CategoryController::class)->group(function () {
    Route::get('/list', 'index');
    Route::get('/{category}', 'show');
    Route::post('/new', 'store');
    Route::put('/update/{category}', 'update');
    Route::delete('/delete/{category}', 'destroy');
});

Route::prefix('banner')->controller(\App\Http\Controllers\Banner\BannerController::class)->group(function () {
    Route::get('/list', 'index');
    Route::get('/{banner}', 'show');
    Route::post('/new', 'store');
    Route::put('/update/{banner}', 'update');
    Route::delete('/delete/{banner}', 'destroy');
});
