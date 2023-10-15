<?php

use Queendev\PhpFramework\Http\Kernel;
use Queendev\PhpFramework\Http\Request;
use Queendev\PhpFramework\Routing\Router;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$request = Request::createFromGlobals();
$router = new Router();
$kernel = new Kernel($router);
$response = $kernel->handle($request);

$response->send();