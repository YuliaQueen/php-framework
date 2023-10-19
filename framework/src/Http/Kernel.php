<?php

namespace Queendev\PhpFramework\Http;

use League\Container\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Http\Exceptions\HttpException;
use Queendev\PhpFramework\Routing\RouterInterface;

class Kernel
{
    private string $appEnv = 'dev';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(
        private RouterInterface $router,
        private Container $container
    )
    {
        $this->appEnv = $container->get('APP_ENV');
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function handle(Request $request): Response
    {
        try {
            [$routerHandler, $vars] = $this->router->dispatch($request, $this->container);
            $response = call_user_func_array($routerHandler, $vars);
        } catch (\Exception $e) {
            return $this->createExceptionResponse($e);
        }

        return $response;
    }

    /**
     * @param \Exception $e
     * @return Response
     * @throws \Exception
     */
    private function createExceptionResponse(\Exception $e): Response
    {
        if (in_array($this->appEnv, ['dev', 'test'])) {
            throw $e;
        }

        if ($e instanceof HttpException) {
            return new Response($e->getMessage(), $e->getStatusCode());
        }

        return new Response('Internal server error', 500);
    }
}