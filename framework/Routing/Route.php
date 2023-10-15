<?php

namespace Queendev\PhpFramework\Routing;

class Route
{
    /**
     * @param string $uri
     * @param array|callable $handler
     * @return array
     */
    public static function get(string $uri, array|callable $handler): array
    {
        return ['GET', $uri, $handler];
    }

    /**
     * @param string $uri
     * @param array|callable $handler
     * @return array
     */
    public static function post(string $uri, array|callable $handler): array
    {
        return ['POST', $uri, $handler];
    }
}