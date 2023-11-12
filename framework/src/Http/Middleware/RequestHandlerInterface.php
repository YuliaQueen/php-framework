<?php

namespace Queendev\PhpFramework\Http\Middleware;

use Queendev\PhpFramework\Http\Request;
use Queendev\PhpFramework\Http\Response;

interface RequestHandlerInterface
{
    public function handle(Request $request): Response;

    public function injectMiddleware(array $middlewares): void;
}