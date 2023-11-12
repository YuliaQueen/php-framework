<?php

namespace Queendev\PhpFramework\Authentication;

interface SessionAuthInterface
{
    public function authenticate(string $email, string $password): bool;

    public function login(AuthUserInterface $user): void;

    public function logout(): void;

    public function getUser(): AuthUserInterface;
}