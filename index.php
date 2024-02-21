<?php

require __DIR__ . '/vendor/autoload.php';


use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/', fn () => 'root');
SimpleRouter::get('/test', fn() => 'test');

SimpleRouter::start();
