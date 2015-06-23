<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app['debug'] = true;

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
$app->post('/perfiles', function(Request $request) use ($app) 
{
	$perfil = $app['db']->dispense('perfiles');

	$perfil->name = $request->get('name');

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
 * Put
 * 
 */
$app->put('/perfiles/{id}', function(Request $request, $id) use ($app)
{
	header("Access-Control-Allow-Origin: *");
	$perfil = $app['db']->load('perfiles', $id);

	$perfil->name = $request->request->get('name');

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
$app->delete('/perfiles/{id}', function($id) use ($app)
{
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