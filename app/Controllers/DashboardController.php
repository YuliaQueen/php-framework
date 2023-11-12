<?php

namespace App\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Controller\AbstractController;
use Queendev\PhpFramework\Http\Response;

class DashboardController extends AbstractController
{
    /**
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): Response
    {
        return $this->render('dashboard', [
            'title' => 'Welcome to dashboard',
        ]);
    }
}