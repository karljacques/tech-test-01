<?php

namespace App\Domain\Repository;

use App\Domain\Model\ListContact;

interface ListContactRepository
{
    public function save(ListContact $listContact): void;

    /** @return array<array-key, ListContact> */
    public function findAll(?string $orderBy = null): array;

    public function removeById(int $id): void;
}
