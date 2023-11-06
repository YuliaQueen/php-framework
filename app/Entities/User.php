<?php

namespace App\Entities;

class User
{
    public function __construct(
        private ?int                    $id,
        private ?string                 $name,
        private string                  $email,
        private string                  $password,
        private \DateTimeImmutable|null $createdAt
    )
    {
    }

    public static function create($email, $password, $name = null, $createdAt = null, $id = null): static
    {
        $createdAt = $createdAt ?? new \DateTimeImmutable();

        return new static(
            $id,
            $name,
            $email,
            $password,
            $createdAt
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}