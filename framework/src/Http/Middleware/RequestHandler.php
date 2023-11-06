<?php

namespace Queendev\PhpFramework\Http\Middleware;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Http\Request;
use Queendev\PhpFramework\Http\Response;

class RequestHandler implements RequestHandlerInterface
{
    private array $middlewares = [
        Authenticate::class,
        RouterDispatch::class
    ];

    public function __construct(
        private ContainerInterface $container
    )
    {

    }

    /**
     * @param Request $request
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Request $request): Response
    {
        if (empty($this->middlewares)) {
            return new Response('Internal server error', 500);
        }

        $middlewareClass = array_shift($this->middlewares);

        $middleware = $this->container->get($middlewareClass);

        return $middleware->process($request, $this);
    }
}