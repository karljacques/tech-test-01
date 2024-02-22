<?php

namespace App\Infrastructure\Repository\InMemory;

use App\Domain\Model\ListContact;
use App\Domain\Repository\ListContactRepository;

class InMemoryListContactRepository implements ListContactRepository
{
    /** @var array<int, ListContact> */
    private array $records = [];


    public function findAll(?string $orderBy = null, string $sortDirection = 'ASC'): array
    {
        // arrays are assigned by copy - don't sort the original array, sort the intermediate
        $records = $this->records;

        if ($orderBy !== null) {
            usort($records, function (ListContact $a, ListContact $b) use ($orderBy, $sortDirection): int {
                $columnFetcher = $this->getColumnFetcher($orderBy);

                $valueA = $columnFetcher($a);
                $valueB = $columnFetcher($b);

                return $sortDirection === 'ASC' ? $valueA <=> $valueB : $valueB <=> $valueA;
            });
        }

        return $records;
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

    /** @return \Closure(ListContact): string */
    private function getColumnFetcher(string $column): \Closure
    {
        // I could use an Enum to make this cleaner. i.e: ListContactColumn::CreatedAt
        return match ($column) {
            'created_at' => fn(ListContact $obj): string => $obj->getCreatedAt()->format(\DateTimeInterface::ATOM),
            'name' => fn(ListContact $obj): string => $obj->getName(),
            'email_address' => fn(ListContact $obj): string => $obj->getEmail(),
            default => throw new \LogicException('Unsupported orderBy column')
        };
    }
}
