<?php

namespace Queendev\PhpFramework\Routing;

use FastRoute\RouteCollector;
use Queendev\PhpFramework\Http\Request;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    /**
     * @param Request $request
     * @return array
     */
    public function dispatch(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        [$status, [$controller, $action], $vars] = $dispatcher->dispatch($request->getMethod(), $request->getPath());

        return [[new $controller, $action], $vars];
    }
}