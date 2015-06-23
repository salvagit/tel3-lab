<?php

// Get Autoloader
require_once __DIR__.'/../vendor/autoload.php';

$container = new Pimple;

$container['db'] = $container->share(function($container) {

    $dsn = sprintf(
        '%s:host=%s;port=%s;dbname=%s',
        'mysql',
        'localhost',
        '3306',
        'tel3labs'
    );

    $user = 'root';
    $pass = '1234';

    RedBean_Facade::setup($dsn, $user, $pass);
    return new RedBean_Facade;
});

return $container;