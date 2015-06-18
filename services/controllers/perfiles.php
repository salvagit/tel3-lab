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
	header("Access-Control-Allow-Origin: *");
	$name = $_POST['name'];

	$perfil = $app['db']->dispense('perfiles');

	$perfil->name = $name;

 	try {
 		$response['success'] = true;
 		$response['message'] = $app['db']->store($perfil);

 		if (is_integer($response['message'])) {
 			try {
 				$id_perfil = $response['message'];
 			} catch (Exception $e) {
		 		$response['success'] = false;
		 		$response['message'] = $e->getMessage();
 			}
 		}

 	} catch (Exception $e) {
 		$response['success'] = false;
 		$response['message'] = $e->getMessage();
 	}
 	return $app->json($response);

});


/**
 * Put
 * 
 */
$app->put('/perfiles/{id}', function($id, Request $request) use ($app) {
	header("Access-Control-Allow-Origin: *");
	
	$perfil = $app['db']->load('perfil', $id);

	$perfil->name = '';

	// var_dump($request->getMethod());
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