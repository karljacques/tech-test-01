<?php

namespace App\Tests\Integration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

trait DatabaseTestTrait
{
    private ?Connection $connection = null;

    /** @before */
    public function startTransaction(): void
    {
        $this->connection = DriverManager::getConnection([
                'host' => 'database',
                'user' => 'root',
                'password' => 'password',
                'driver' => 'pdo_mysql',
                'dbname' => 'tech-test-01_test'
            ]
        );

        $this->connection->executeQuery('START TRANSACTION');
    }

    /** @after */
    public function endTransaction(): void
    {
        $this->getConnection()->executeQuery('ROLLBACK');
    }

    protected function getConnection(): Connection
    {
        if ($this->connection === null) {
            throw new \RuntimeException('Connection has not been instantiated');
        }

        return $this->connection;
    }
}
