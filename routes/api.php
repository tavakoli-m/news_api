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


Route::prefix('comment')->controller(\App\Http\Controllers\Comment\CommentController::class)->group(function () {
    Route::get('/list', 'index');
    Route::get('/toggle-status/{comment}', 'toggleStatus');
});

Route::prefix('user')->controller(\App\Http\Controllers\User\UserController::class)->group(function () {
    Route::get('/list', 'index');
    Route::get('/toggle-role/{user}', 'toggleRole');
});


Route::prefix('post')->controller(\App\Http\Controllers\Post\PostController::class)->group(function () {
    Route::get('/list', 'index');
    Route::get('/{post}', 'show');
    Route::get('/toggle-selected/{post}', 'toggleSelected');
    Route::get('/toggle-breaking-news/{post}', 'toggleBreakingNews');
    Route::post('/new', 'store');
    Route::put('/update/{post}', 'update');
    Route::delete('/delete/{post}', 'destroy');
});
