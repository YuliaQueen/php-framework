<?php

namespace Queendev\PhpFramework\Http;

use Queendev\PhpFramework\Routing\RouterInterface;

class Kernel
{
    public function __construct(
        private RouterInterface $router
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
            [$routerHandler, $vars] = $this->router->dispatch($request);
            $response = call_user_func_array($routerHandler, $vars);
        } catch (\Throwable $e) {
            $response = new Response($e->getMessage(), 500);
        }

        return $response;
    }
}