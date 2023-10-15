<?php

use Queendev\PhpFramework\Http\Kernel;
use Queendev\PhpFramework\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$request = Request::createFromGlobals();
$kernel = new Kernel();
$response = $kernel->handle($request);

$response->send();