<?php

namespace Queendev\PhpFramework\Routing;

use FastRoute\RouteCollector;
use Queendev\PhpFramework\Http\Exceptions\MethodNotAllowedException;
use Queendev\PhpFramework\Http\Exceptions\RouteNotFoundException;
use Queendev\PhpFramework\Http\Request;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    /**
     * @param Request $request
     * @return array
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
    public function dispatch(Request $request): array
    {
        [$handler, $vars] = $this->extractRouteInfo($request);

        [$controller, $action] = $handler;

        return [[new $controller, $action], $vars];
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
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
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
                throw new MethodNotAllowedException($message);
            default:
                throw new RouteNotFoundException('Route not found');
        }
    }
}