<?php

namespace App\Forms\User;

use App\Entities\User;
use App\Services\UserService;
use Doctrine\DBAL\Exception;

class RegisterForm
{
    const MIN_NAME_LENGTH = 3;
    const MAX_NAME_LENGTH = 30;
    const MIN_PASSWORD_LENGTH = 6;

    private ?string $name;
    private string $email;
    private string $password;
    private string $passwordConfirmation;

    public function __construct(
        private UserService $userService
    )
    {

    }

    public function setFields(
        string $email,
        string $password,
        string $passwordConfirmation,
        string $name = null
    ): void
    {
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
        $this->name = $name;
    }

    /**
     * @return User
     * @throws Exception
     */
    public function save(): User
    {
        $user = User::create(
            $this->email,
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->name,
            new \DateTimeImmutable()
        );

        return $this->userService->save($user);
    }

    public function getValidationErrors(): array
    {
        $errors = [];

        if (!empty($this->name) && strlen($this->name) < self::MIN_NAME_LENGTH) {
            $errors[] = sprintf('Name must be at least %d characters', self::MIN_NAME_LENGTH);
        }

        if (!empty($this->name) && strlen($this->name) > self::MAX_NAME_LENGTH) {
            $errors[] = sprintf('Name must be less than %d characters', self::MAX_NAME_LENGTH);
        }

        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email';
        }

        if (empty($this->password) || strlen($this->password) < self::MIN_PASSWORD_LENGTH) {
            $errors[] = sprintf('Password must be at least %d characters', self::MIN_PASSWORD_LENGTH);
        }

        if (empty($this->passwordConfirmation) || $this->password !== $this->passwordConfirmation) {
            $errors[] = 'Passwords do not match';
        }

        return $errors;
    }

    public function hasValidationErrors(): bool
    {
        return !empty($this->getValidationErrors());
    }
}