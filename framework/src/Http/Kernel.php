<?php

namespace Queendev\PhpFramework\Http;

use League\Container\Container;
use Queendev\PhpFramework\Http\Exceptions\HttpException;
use Queendev\PhpFramework\Routing\RouterInterface;

class Kernel
{
    public function __construct(
        private RouterInterface $router,
        private Container $container
    )
    {
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        try {
            [$routerHandler, $vars] = $this->router->dispatch($request, $this->container);
            $response = call_user_func_array($routerHandler, $vars);
        } catch (HttpException $e) {
            $response = new Response($e->getMessage(), $e->getStatusCode());
        } catch (\Throwable $e) {
            $response = new Response($e->getMessage(), 500);
        }

        return $response;
    }
}