<?php

namespace Queendev\PhpFramework\Routing;

use Queendev\PhpFramework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}