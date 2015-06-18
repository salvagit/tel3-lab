<?php

use Silex\Application;

$app = new Application();

// little helper...
$app['json.request'] = function($app) {
    return json_decode($app['request']->getContent());
};

// get container.
$app['container'] = require_once __DIR__ .'/container.php';
$container = $app['container'];

// shortcut db
$app['db'] = $app->share(function($app) {
    return $app['container']['db'];
});

return $app;