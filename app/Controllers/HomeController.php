<?php

namespace App\Controllers;

use Queendev\PhpFramework\Http\Response;

class HomeController
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $content = 'Hello World from Controller!';

        return new Response($content);
    }
}