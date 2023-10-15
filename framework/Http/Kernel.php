<?php

namespace Queendev\PhpFramework\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{
    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

        [$status, [$controller, $action], $vars] = $routInfo;

        return call_user_func_array([new $controller, $action], $vars);
    }
}