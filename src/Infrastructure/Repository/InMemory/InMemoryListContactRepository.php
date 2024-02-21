<?php

namespace App\Infrastructure\Repository\InMemory;

use App\Domain\Model\ListContact;
use App\Domain\Repository\ListContactRepository;

class InMemoryListContactRepository implements ListContactRepository
{
    /** @var array<int, ListContact> */
    private array $records = [];


    public function findAll(?string $orderBy = null): array
    {
        // TODO: Implement orderBy
        return $this->records;
    }

    public function removeById(int $id): void
    {
        unset($this->records[$id]);
    }

    public function save(ListContact $listContact): void
    {
        $id = count($this->records) + 1;

        // Use reflection to set the id on listContact
        $refl = new \ReflectionClass($listContact);
        $reflProp = $refl->getProperty('id');

        $reflProp->setValue($listContact, $id);

        $this->records[$listContact->getId()] = $listContact;
    }
}
