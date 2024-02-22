<?php

namespace App\Infrastructure\Repository\DBAL;

use App\Domain\Model\ListContact;
use App\Domain\Repository\ListContactRepository;
use Doctrine\DBAL\Connection;

final readonly class DBALListContactRepository implements ListContactRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function save(ListContact $listContact): void
    {
        $this->connection->executeQuery("
INSERT INTO list_contact
 (email_address, `name`, created_at)
VALUES (:email_address, :name, :created_at)", [
            'email_address' => $listContact->getEmail(),
            'name' => $listContact->getName(),
            'created_at' => $listContact->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);


        // I'd like do some abstraction here for a real project.
        $id = $this->connection->lastInsertId();

        $refl = new \ReflectionClass($listContact);
        $reflProp = $refl->getProperty('id');

        $reflProp->setValue($listContact, $id);
    }

    public function findAll(?string $orderBy = null, string $sortDirection = 'ASC'): array
    {
        $sql = "SELECT id, email_address, name, created_at FROM list_contact";

        if ($orderBy !== null) {
            // Security of this would be improved with an enum for the ordering column and direction - right now it could be any input
            $sql .= " ORDER BY $orderBy $sortDirection";
        }

        $results = $this->connection->executeQuery($sql);
        $rows = [];

        while ($row = $results->fetchAssociative()) {
            /** @var array{id: int, email_address: string, name: string, created_at: string} $row */
            $rows[] = ListContact::fromDatabase($row);
        }

        return $rows;
    }

    public function removeById(int $id): void
    {
        // I might've add error checking and handling here with more time
        $this->connection->executeQuery("DELETE FROM list_contact WHERE id = :id LIMIT 1", [
            'id' => $id
        ]);
    }
}
