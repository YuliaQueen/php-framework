<?php

namespace App\Controllers;

use Queendev\PhpFramework\Http\Response;

class PostsController
{
    /**
     * @param int $id
     * @return Response
     */
    public function view(int $id): Response
    {
        return new Response('View POST #: ' . $id);
    }
}