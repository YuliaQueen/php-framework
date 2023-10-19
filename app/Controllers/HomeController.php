<?php

namespace App\Controllers;

use Queendev\PhpFramework\Controller\AbstractController;
use Queendev\PhpFramework\Http\Response;

class HomeController extends AbstractController
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