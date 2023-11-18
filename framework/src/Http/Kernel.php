<?php

namespace Queendev\PhpFramework\Http;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Event\EventDispatcher;
use Queendev\PhpFramework\Http\Events\ResponseEvent;
use Queendev\PhpFramework\Http\Exceptions\HttpException;
use Queendev\PhpFramework\Http\Middleware\RequestHandlerInterface;

class Kernel
{
    private string $appEnv = 'dev';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(
        private readonly ContainerInterface      $container,
        private readonly RequestHandlerInterface $requestHandler,
        private readonly EventDispatcher         $eventDispatcher
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
            $response = $this->requestHandler->handle($request);
        } catch (\Exception $e) {
            return $this->createExceptionResponse($e);
        }

        $this->eventDispatcher->dispatch(new ResponseEvent($request, $response));

        return $response;
    }

    public function terminate(Request $request, Response $response): void
    {
        $request->getSession()?->clearFlash();
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