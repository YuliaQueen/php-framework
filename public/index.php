<?php

use Queendev\PhpFramework\Http\Kernel;
use Queendev\PhpFramework\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$container = require BASE_PATH . '/config/services.php';

require_once BASE_PATH . '/bootstrap/bootstrap.php';

$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);