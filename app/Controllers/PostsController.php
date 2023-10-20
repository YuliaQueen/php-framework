<?php

namespace App\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Controller\AbstractController;
use Queendev\PhpFramework\Http\Response;

class PostsController extends AbstractController
{

    /**
     * @param int $id
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function view(int $id): Response
    {
        return $this->render('post', [
            'id' => $id
        ]);
    }
}