<?php

namespace App\Tests\Unit\Infrastructure\Repository\InMemory;

use App\Domain\Repository\ListContactRepository;
use App\Infrastructure\Repository\InMemory\InMemoryListContactRepository;
use App\Tests\Common\Domain\Repository\ListContactRepositoryTestCase;

class InMemoryListContactRepositoryTest extends ListContactRepositoryTestCase
{
    protected function getRepositoryUnderTest(): ListContactRepository
    {
        return new InMemoryListContactRepository();
    }
}
