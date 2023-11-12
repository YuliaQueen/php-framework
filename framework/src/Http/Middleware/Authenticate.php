<?php

namespace Queendev\PhpFramework\Http\Middleware;

use Queendev\PhpFramework\Authentication\SessionAuthInterface;
use Queendev\PhpFramework\Http\RedirectResponse;
use Queendev\PhpFramework\Http\Request;
use Queendev\PhpFramework\Http\Response;
use Queendev\PhpFramework\Session\SessionInterface;

class Authenticate implements MiddlewareInterface
{
    public function __construct(
        private SessionAuthInterface $auth,
        private SessionInterface     $session
    )
    {

    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $this->session->start();
        
        if (!$this->auth->check()) {
            $this->session->setFlash('error', 'Please login');
            return new RedirectResponse('/login');
        }

        return $handler->handle($request);
    }
}