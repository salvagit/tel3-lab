<?php

// Get Autoloader
require_once __DIR__.'/../vendor/autoload.php';

$container = new Pimple;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../templates',
));

$container['db'] = $container->share(function($container) {

    $dsn = sprintf(
        '%s:host=%s;port=%s;dbname=%s',
        'mysql',
        'localhost',
        '3306',
        'tel3labs'
    );

    $user = 'root';
    $pass = '';

    RedBean_Facade::setup($dsn, $user, $pass);
    return new RedBean_Facade;
});

return $container;