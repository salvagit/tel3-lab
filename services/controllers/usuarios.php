<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Get
 * 
 */
$app->get('/usuarios', function() use ($app) 
{
   	$data = $app['db']->getAll('SELECT * FROM usuarios');

   	// seteando parametros para la vista
   	$params['data'] = $data;
   	// renderisamos
   	return $app['twig']->render('usuarios.twig', $params);
});

/**
 * Post
 * 
 */
$app->post('/usuarios', function(Request $request) use ($app) 
{
	$user = $app['db']->dispense('usuarios');

	$user->name = $request->get('name');
	$user->mail = $request->get('mail');
	$user->id_perfil = $request->get('id_perfil');
	var_dump($user); die;
 	try {
 		$response['success'] = true;
 		$response['message'] = $app['db']->store($user);
 	} catch (Exception $e) {
 		$response['success'] = false;
 		$response['message'] = $e->getMessage();
 	}

 	return $app->json($response);
});