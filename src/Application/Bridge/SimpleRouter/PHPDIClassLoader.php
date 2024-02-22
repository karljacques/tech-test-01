<?php

namespace App\Application\Bridge\SimpleRouter;

use DI\Container;
use Pecee\SimpleRouter\ClassLoader\IClassLoader;
use Pecee\SimpleRouter\Exceptions\ClassNotFoundHttpException;

// Taken from https://packagist.org/packages/pecee/simple-router
class PHPDIClassLoader implements IClassLoader
{
    public function __construct(
        private Container $container
    )
    {

    }

    /**
     * @template T of object
     * @param string|class-string<T> $class
     * @return object|T
     */
    public function loadClass(string $class): object
    {
        if ($this->container->has($class) === false) {
            throw new ClassNotFoundHttpException($class, null, sprintf('Class "%s" does not exist', $class), 404, null);
        }
        $service = $this->container->get($class);

        if (!is_object($service)) {
            throw new \LogicException('IClassLoader must return an object');
        }

        return $service;
    }


    public function loadClassMethod($class, string $method, array $parameters): string
    {
        return (string)$this->container->call([$class, $method], $parameters);
    }

    public function loadClosure(callable $closure, array $parameters): string
    {
        return (string)$this->container->call($closure, $parameters);
    }
}
