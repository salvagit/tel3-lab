<?php

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

/**
 * Get
 * 
 */
$app->get('/perfiles', function() use ($app) 
{
   	$data = $app['db']->getAll('SELECT * FROM perfiles');
 	return  $app->json($data);
});


/**
 * Post
 * 
 */
$app->post('/perfiles', function() use ($app) 
{
	$name = $_POST['name'];

	$sql = <<<SQL
INSERT INTO perfiles (id, name) VALUES (NULL, $name);
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


/**
 * Put
 * 
 */
$app->put('/perfiles/{id}', function($id, Request $request) use ($app) {
	header("Access-Control-Allow-Origin: *");
	
	$perfil = $app['db']->load('perfil', $id);

	$perfil->name = '';

	var_dump($request->getMethod());
	var_dump($request->get('name'));
	// var_dump($app['request']->getContent());
	// var_dump($app['request']->getContent());

 	try {
 		$response['success'] = true;
 		$response['message'] = $app['db']->store($perfil);
 	} catch (Exception $e) {
 		$response['success'] = false;
 		$response['message'] = $e->getMessage();
 	}
 	return $app->json($response);
});


/**
 * Delete
 * 
 */
$app->delete('/perfiles/{id}', function($id) use ($app) {
	header("Access-Control-Allow-Origin: *");
	$perfil = $app['db']->load('perfiles', $id);
	try {
 		$response['success'] = true;
 		$response['message'] = $app['db']->trash($perfil);
 	} catch (Exception $e) {
 		$response['success'] = false;
 		$response['message'] = $e->getMessage();
 	}
 	return $app->json($response);
});