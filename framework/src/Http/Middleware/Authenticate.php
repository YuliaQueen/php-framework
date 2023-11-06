<?php

namespace Queendev\PhpFramework\Http\Middleware;

use Queendev\PhpFramework\Http\Request;
use Queendev\PhpFramework\Http\Response;

class Authenticate implements MiddlewareInterface
{
    private bool $authenticated = true; // TODO: Implement authenticated property

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        if (!$this->authenticated) {
            return new Response('Unauthorized', 401);
        }

        return $handler->handle($request);
    }
}