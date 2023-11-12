<?php

namespace Queendev\PhpFramework\Authentication;

interface UserServiceInterface
{
    public function findByEmail(string $email): ?AuthUserInterface;
}