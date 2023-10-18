<?php

namespace Queendev\PhpFramework\Routing;

use League\Container\Container;
use Queendev\PhpFramework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request, Container $container): array;

    public function registerRoutes(array $routes): void;
}