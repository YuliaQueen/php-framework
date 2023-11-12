<?php

use Queendev\PhpFramework\Http\Middleware\Authenticate;
use Queendev\PhpFramework\Http\Middleware\Guest;
use Queendev\PhpFramework\Routing\Route;

return [
    Route::get('/', [\App\Controllers\HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [\App\Controllers\PostsController::class, 'view']),
    Route::get('/posts/create', [\App\Controllers\PostsController::class, 'create'], [Authenticate::class]),
    Route::post('/posts', [\App\Controllers\PostsController::class, 'store']),
    Route::get('/blog', [\App\Controllers\PostsController::class, 'all']),
    Route::get('/register', [\App\Controllers\RegisterController::class, 'form'], [Guest::class]),
    Route::post('/register', [\App\Controllers\RegisterController::class, 'register']),
    Route::get('/login', [\App\Controllers\LoginController::class, 'form'], [Guest::class]),
    Route::post('/login', [\App\Controllers\LoginController::class, 'login']),
    Route::get('/logout', [\App\Controllers\LoginController::class, 'logout']),
    Route::get('/dashboard', [\App\Controllers\DashboardController::class, 'index'], [Authenticate::class]),
];