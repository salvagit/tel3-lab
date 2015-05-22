<?php

$app->get('/', function() use ($app) 
{
   	$data = $app['db']->getAll('SELECT * FROM perfiles');
 	return  $app->json($data);
});
