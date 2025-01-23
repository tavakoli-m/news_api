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
