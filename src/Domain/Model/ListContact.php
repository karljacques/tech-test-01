<?php

namespace App\Domain\Model;

use Carbon\CarbonImmutable;

final class ListContact
{
    private ?int $id = null;

    private \DateTimeImmutable $createdAt;

    public function __construct(
        private string $email,
        private string $name,

    )
    {
        $this->createdAt = CarbonImmutable::now();
    }

    /**
     * @param array{id: int, email_address: string, name: string, created_at: string} $data
     */
    public static function fromDatabase(array $data): self
    {
        // Create without the constructor
        $refl = new \ReflectionClass(ListContact::class);
        $obj = $refl->newInstanceWithoutConstructor();

        $obj->id = $data['id'];
        $obj->email = $data['email_address'];
        $obj->name = $data['name'];
        $obj->createdAt = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['created_at']) ?: throw new \RuntimeException('Unabled to created valid DateTimeImmutable from format');

        return $obj;
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
