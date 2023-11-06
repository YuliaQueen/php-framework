<?php

namespace Queendev\PhpFramework\Http\Middleware;

use Queendev\PhpFramework\Http\Request;
use Queendev\PhpFramework\Http\Response;

interface MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response;
}