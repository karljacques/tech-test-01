<?php

namespace App\Domain\Model;

final class ListContact
{
    private ?int $id = null;

    private \DateTimeImmutable $createdAt;

    public function __construct(
        private string $email,
        private string $name,

    )
    {
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getId(): int
    {
        if ($this->id === null) {
            throw new \LogicException('Id has not yet been set.');
        }

        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }


}
