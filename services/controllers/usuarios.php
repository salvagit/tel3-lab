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
$app->get('/getusuario/{id}', function($id) use ($app) 
{
      $sql = <<<SQL
SELECT u.*, up.perfiles_id as perfil
FROM usuarios u 
JOIN usuarios_perfiles up ON (up.usuarios_id = u.id)
WHERE u.id = $id
SQL;
   	$data = $app['db']->getAll($sql);
   	return $app->json($data);
});

/**
 * Get
 * 
 */
$app->get('/usuarios', function() use ($app) 
{
      // get users from db
   	$data = $app['db']->getAll('SELECT * FROM usuarios');
   	// seteando parametros para la vista
   	$params['data'] = $data;
   	// renderisamos
   	return $app['twig']->render('usuarios/usuarios.twig', $params);
});

/**
 * Post
 * 
 */
$app->post('/usuario', function(Request $request) use ($app) 
{
	$user = $app['db']->dispense('usuarios');

	$user->name = $request->get('name');
   $user->mail = $request->get('mail');

   $user_id = $app['db']->store($user);

	$perfiles_id = $request->get('perfil_id');

   // do query insert maxi
   $sql = <<<SQL
INSERT INTO usuarios_perfiles (usuarios_id, perfiles_id) 
VALUES ($user_id, $perfiles_id)
SQL;
   $response['sql'] = $sql;
   $response['data'] = $app['db']->getAll($sql);

   try {
      $response['success'] = true;
      $response['message'] = $app['db']->store($user);
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
$app->put('/usuario/{id}', function(Request $request, $id) use ($app)
{
   header("Access-Control-Allow-Origin: *");
   $usuario = $app['db']->load('usuarios', $id);

   $usuario->name = $request->request->get('name');
   $usuario->mail = $request->request->get('mail');
   $perfiles_id = $request->request->get('perfil_id');

   // borrar todos los perfiles de este usuario.
   $response['delete'] = $app['db']->getAll("DELETE FROM usuarios_perfiles WHERE usuarios_id = $id");

   // do query insert maxi
   $sql = <<<SQL
INSERT INTO usuarios_perfiles (usuarios_id, perfiles_id) 
VALUES ($id, $perfiles_id)
SQL;
   $response['sql'] = $sql;
   $response['data'] = $app['db']->getAll($sql);

   try {
      $response['success'] = true;
      $response['message'] = $app['db']->store($usuario);
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
$app->delete('/usuario/{id}', function($id) use ($app)
{
   $usuario = $app['db']->load('usuarios', $id);
   try {
      $response['success'] = true;
      $response['message'] = $app['db']->trash($usuario);
   } catch (Exception $e) {
      $response['success'] = false;
      $response['message'] = $e->getMessage();
   }
   return $app->json($response);
});
