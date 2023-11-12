<?php

namespace App\Controllers;

use App\Services\UserService;
use Queendev\PhpFramework\Authentication\SessionAuthInterface;
use Queendev\PhpFramework\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function __construct(
        protected SessionAuthInterface $auth,
        protected UserService $userService
    )
    {
    }
}