<?php
/**
 * This task asked for no framework to be used.
 * To adequately portray how I'd complete this task, I do need
 * some bare minimums of a framework, which is why I have included
 * a super simple router, container and templating engine.
 */

require __DIR__ . '/../vendor/autoload.php';

use App\Application\Bridge\SimpleRouter\PHPDIClassLoader;
use App\Domain\Repository\ListContactRepository;
use App\Infrastructure\Repository\DBAL\DBALListContactRepository;
use App\Infrastructure\Repository\InMemory\InMemoryListContactRepository;
use App\Ports\API\AddListContactController;
use App\Ports\API\DeleteListContactController;
use App\Ports\Web\IndexController;
use DevCoder\Renderer\PhpRenderer;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Pecee\SimpleRouter\SimpleRouter;

$builder = new DI\ContainerBuilder();

$builder->addDefinitions([
    Connection::class => DI\Factory(function () {
        // In production, you would load these details from env
        return DriverManager::getConnection([
            'dbname' => 'tech-test-01',
            'host' => 'database',
            'user' => 'root',
            'password' => 'password',
            'driver' => 'pdo_mysql'
        ]);
    }),
    ListContactRepository::class => DI\get(DBALListContactRepository::class),
    // I'd usually use twig - but this library is very basic and keeps it close to vanilla php
    PhpRenderer::class => DI\Factory(function () {
        return new PhpRenderer(__DIR__ . '/../src/Application/Templates/');
    })
]);

$container = $builder->build();

SimpleRouter::setCustomClassLoader(new PHPDIClassLoader($container));

SimpleRouter::get('/', [IndexController::class, '__invoke']);
SimpleRouter::post('/listContact', [AddListContactController::class, 'add']);
SimpleRouter::delete('/listContact/{id}', [DeleteListContactController::class, 'delete']);

SimpleRouter::start();
