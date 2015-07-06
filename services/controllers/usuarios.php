<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Get
 * 
 */
$app->get('/getusuarios', function() use ($app) 
{
   	$data = $app['db']->getAll('SELECT * FROM usuarios');
   	
   	foreach ($data as $k => &$v) {
   		$v['actions'] = $app['twig']->render('usuarios/actions.twig', $v);
   	}

   	return $app->json($data);
});

/**
 * Get
 * 
 */
$app->get('/usuarios', function() use ($app) 
{
   	$data = $app['db']->getAll('SELECT * FROM usuarios');

   	// seteando parametros para la vista
   	$params['data'] = $data;
   	$params['basepath'] = 'http://tel3.labs/';
   	// renderisamos
   	return $app['twig']->render('usuarios/usuarios.twig', $params);
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