<?php

namespace App\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Controller\AbstractController;
use Queendev\PhpFramework\Http\Response;

class RegisterController extends AbstractController
{
    /**
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function form(): Response
    {
        return $this->render('/register/form');
    }

    public function register()
    {
        dd($this->request);
    }
}