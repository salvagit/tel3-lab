<?php

$app->get('/perfiles', function() use ($app) 
{
   	$data = $app['db']->getAll('SELECT * FROM perfiles');
 	return  $app->json($data);
});

$app->post('/perfiles', function() use ($app) 
{
	$name = $_POST['name'];

	$sql = <<<SQL
INSERT INTO perfiles ('name') VALUES ($name)
SQL;
	try {
   		$response['status'] = 'success'; 
   		$response['message'] = $app['db']->getAll($sql);
	} catch (Exception $e) {
   		$response['status'] = 'success'; 
   		$response['message'] = $app['db']->getAll($sql);
	}
 	return  $app->json($response);
});
