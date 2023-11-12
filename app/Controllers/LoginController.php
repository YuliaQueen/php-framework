<?php

namespace App\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Controller\AbstractController;
use Queendev\PhpFramework\Http\Response;

class LoginController extends AbstractController
{
    /**
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function form(): Response
    {
        return $this->render('login/form');
    }

    public function login(): Response
    {
        dd($this->request);
    }
}