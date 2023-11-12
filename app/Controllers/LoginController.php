<?php

namespace App\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Authentication\SessionAuthInterface;
use Queendev\PhpFramework\Controller\AbstractController;
use Queendev\PhpFramework\Http\RedirectResponse;
use Queendev\PhpFramework\Http\Response;

class LoginController extends AbstractController
{
    public function __construct(
        private SessionAuthInterface $auth
    )
    {
    }

    /**
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function form(): Response
    {
        return $this->render('login/form');
    }

    public function login(): RedirectResponse
    {
        $isAuth = $this->auth->authenticate(
            $this->request->input('email'),
            $this->request->input('password')
        );

        if (!$isAuth) {
            $this->request->getSession()->setFlash('error', 'Wrong login or password');
            return new RedirectResponse('/login');
        }

        $this->request->getSession()->setFlash('success', 'Welcome back!');

        return new RedirectResponse('/dashboard');
    }
}