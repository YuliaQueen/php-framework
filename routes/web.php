<?php

use Queendev\PhpFramework\Routing\Route;

return [
    Route::get('/', [\App\Controllers\HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [\App\Controllers\PostsController::class, 'view']),
    Route::get('/posts/create', [\App\Controllers\PostsController::class, 'create']),
    Route::get('/blog', [\App\Controllers\PostsController::class, 'all']),
    Route::post('/posts', [\App\Controllers\PostsController::class, 'store']),
    Route::get('/register', [\App\Controllers\RegisterController::class, 'form']),
    Route::post('/register', [\App\Controllers\RegisterController::class, 'register']),
    Route::get('/login', [\App\Controllers\LoginController::class, 'form']),
    Route::post('/login', [\App\Controllers\LoginController::class, 'login']),
    Route::get('/logout', [\App\Controllers\LoginController::class, 'logout']),
    Route::get('/dashboard', [\App\Controllers\DashboardController::class, 'index']),
];