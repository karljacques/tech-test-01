<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

return [
    Connection::class => DI\Factory(function () {
        return DriverManager::getConnection([
            'dbname' => 'tech-test-01',
            'user' => 'root',
            'password' => 'password',
            'driver' => 'pdo_mysql'
        ]);
    })
];
