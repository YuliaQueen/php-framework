<?php

namespace Queendev\PhpFramework\Http\Middleware;

use Psr\Container\ContainerInterface;
use Queendev\PhpFramework\Http\Request;
use Queendev\PhpFramework\Http\Response;
use Queendev\PhpFramework\Routing\RouterInterface;

class RouterDispatch implements MiddlewareInterface
{
    public function __construct(
        private RouterInterface    $router,
        private ContainerInterface $container
    )
    {
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        [$routerHandler, $vars] = $this->router->dispatch($request, $this->container);
        return call_user_func_array($routerHandler, $vars);
    }
}