<?php

namespace App\Tests\Integration\Domain\Repository;

use App\Domain\Repository\ListContactRepository;
use App\Infrastructure\Repository\DBAL\DBALListContactRepository;
use App\Tests\Common\Domain\Repository\ListContactRepositoryTestCase;
use App\Tests\Integration\DatabaseTestTrait;

class DBALListContactRepositoryTest extends ListContactRepositoryTestCase
{
    use DatabaseTestTrait;

    protected function getRepositoryUnderTest(): ListContactRepository
    {
        return new DBALListContactRepository(
            $this->getConnection()
        );
    }
}
