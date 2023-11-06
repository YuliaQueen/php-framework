<?php

namespace Queendev\PhpFramework\Http\Middleware;

use Queendev\PhpFramework\Http\Request;
use Queendev\PhpFramework\Http\Response;
use Queendev\PhpFramework\Session\SessionInterface;

class StartSession implements MiddlewareInterface
{
    public function __construct(
        private SessionInterface $session
    )
    {

    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $this->session->start();
        $request->setSession($this->session);

        return $handler->handle($request);
    }
}