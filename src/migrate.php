<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

require __DIR__ . '/../vendor/autoload.php';

$connection = DriverManager::getConnection([
        'host' => 'database',
        'user' => 'root',
        'password' => 'password',
        'driver' => 'pdo_mysql'
    ]
);

// Ideally, this would use a real migration system that would know if this has already executed
// but this just nukes and recreates
$migrateDatabase = function (Connection $connection, string $schema): void {
    $connection->executeQuery("DROP DATABASE IF EXISTS `$schema`");
    $connection->executeQuery("CREATE DATABASE `$schema`");

    $connection->executeQuery("USE `$schema`");

    $connection->executeQuery("
CREATE TABLE list_contact (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
email_address VARCHAR(254) NOT NULL UNIQUE,
name VARCHAR(200) NOT NULL,
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);");

    echo "Created database $schema\n";
};

$migrateDatabase($connection, 'tech-test-01');
$migrateDatabase($connection, 'tech-test-01_test');



