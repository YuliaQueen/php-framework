<?php

namespace App\Entities;

class Post
{
    public function __construct(
        private ?int $id,
        private string $title,
        private string $content,
        private \DateTimeImmutable|null $createdAt
    )
    {
    }
    public static function create($title, $content, $id = null, $createdAt = null): self
    {
        $createdAt = $createdAt ?? new \DateTimeImmutable();

        return new self(
            $id,
            $title,
            $content,
            $createdAt
        );
    }
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}