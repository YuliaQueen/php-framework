<?php

use Queendev\PhpFramework\Routing\Route;

return [
    Route::get('/', [\App\Controllers\HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [\App\Controllers\PostsController::class, 'view']),
    Route::get('/hi/{name:\w+}', function ($name) {
        return new \Queendev\PhpFramework\Http\Response(sprintf('Hello, %s!', $name));
    })
];