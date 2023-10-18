<?php

namespace Queendev\PhpFramework\Routing;

use FastRoute\RouteCollector;
use Queendev\PhpFramework\Http\Exceptions\MethodNotAllowedException;
use Queendev\PhpFramework\Http\Exceptions\RouteNotFoundException;
use Queendev\PhpFramework\Http\Request;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    const STATUS_NOT_ALLOWED = 405;
    const STATUS_NOT_FOUND = 404;

    private array $routes = [];

    /**
     * @param Request $request
     * @return array
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
    public function dispatch(Request $request): array
    {
        [$handler, $vars] = $this->extractRouteInfo($request);

        if (is_array($handler)) {
            [$controller, $action] = $handler;
            $handler = [new $controller, $action];
        }

        return [$handler, $vars];
    }

    /**
     * @param array $routes
     * @return void
     */
    public function registerRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * @param Request $request
     * @return array
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            foreach ($this->routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routeInfo[1]);
                $message = 'Supported methods: ' . $allowedMethods;
                $exception = new MethodNotAllowedException($message);
                $exception->setStatusCode(self::STATUS_NOT_ALLOWED);
                throw $exception;
            default:
                $exception = new RouteNotFoundException('Route not found');
                $exception->setStatusCode(self::STATUS_NOT_FOUND);
                throw $exception;
        }
    }
}
