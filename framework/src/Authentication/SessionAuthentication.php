<?php

namespace Queendev\PhpFramework\Authentication;

use Queendev\PhpFramework\Session\Session;
use Queendev\PhpFramework\Session\SessionInterface;

class SessionAuthentication implements SessionAuthInterface
{
    private AuthUserInterface $user;

    public function __construct(
        private UserServiceInterface $userService,
        private SessionInterface     $session
    )
    {
    }

    public function authenticate(string $email, string $password): bool
    {
        $user = $this->userService->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->getPassword())) {
            $this->login($user);

            return true;
        }

        return false;
    }

    public function login(AuthUserInterface $user): void
    {
        $this->session->set(Session::USER_ID_KEY, $user->getId());

        $this->user = $user;
    }

    public function logout(): void
    {
        // TODO: Implement logout() method.
    }

    public function getUser(): AuthUserInterface
    {
        return $this->user;
    }
}