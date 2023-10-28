<?php

use Queendev\PhpFramework\Routing\Route;

return [
    Route::get('/', [\App\Controllers\HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [\App\Controllers\PostsController::class, 'view']),
    Route::get('/posts/create', [\App\Controllers\PostsController::class, 'create']),
    Route::post('/posts', [\App\Controllers\PostsController::class, 'store'])
];