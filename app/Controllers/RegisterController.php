<?php

namespace App\Controllers;

use App\Forms\User\RegisterForm;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Http\RedirectResponse;
use Queendev\PhpFramework\Http\Response;

class RegisterController extends DefaultController
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

    public function register(): RedirectResponse
    {
        $redirectResponse = new RedirectResponse('/register');

        $form = new RegisterForm($this->userService);
        $form->setFields(
            $this->request->input('email'),
            $this->request->input('password'),
            $this->request->input('password_confirmation'),
            $this->request->input('name')
        );

        if ($form->hasValidationErrors()) {
            foreach ($form->getValidationErrors() as $error) {
                $this->request->getSession()->setFlash('error', $error);
            }

            return $redirectResponse;
        }

        try {
            $user = $form->save();
            $this->auth->login($user);
            $this->request->getSession()->setFlash('success', 'Your account has been created');
            return new RedirectResponse('/dashboard');
        } catch (Exception $exception) {
            $this->request->getSession()->setFlash('error', $exception->getMessage());
            return $redirectResponse;
        }
    }
}