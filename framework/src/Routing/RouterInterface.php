<?php

namespace Queendev\PhpFramework\Routing;

use Psr\Container\ContainerInterface;
use Queendev\PhpFramework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container): array;

    public function registerRoutes(array $routes): void;
}