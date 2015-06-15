<?php

$app->get('/', function() use ($app) 
{
   	$data = $app['db']->getAll('SELECT * FROM busquedas');
 	return  $app->json($data);
});