<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Get
 * 
 */
$app->get('/get-perfiles', function() use ($app) 
{
   	$data = $app['db']->getAll('SELECT * FROM perfiles');
 	return  $app->json($data);
});

$app->get('/ficha/{id}', function($id) use ($app) 
{
    $dataPerfiles = $app['db']->getAll("SELECT * FROM perfiles where id = $id");
    $dataUsuarios = $app['db']->getAll("SELECT * FROM usuarios where id = $id");
    $respuesta['perfil'] = $dataPerfiles;
    $respuesta['usuario'] = $dataUsuarios;
    $respuesta['titulo'] = "prueba";
    $respuesta['basepath'] = "http://tel3-lab.local:8080";


    //return  $app->json($respuesta);

    return $app['twig']->render('ficha/fichaT.twig',$respuesta);    
});

$app->get('/perfiles', function(Request $request) use ($app) 
{
    $params['basepath'] = 'http://tel3.labs/';
    return $app['twig']->render('perfiles/perfiles.twig', $params);
});

/**
 * Post
 * 
 */
$app->post('/perfiles', function(Request $request) use ($app) 
{
    $file_bag = $request->files;

    if ($file_bag) {
        if ( $file_bag->has('image') )
        {
            $image = $file_bag->get('image');
            $image->move(
                $app['upload_folder'], 
                tempnam($app['upload_folder'],'img_')
            );
        }

        // This is just temporary.
        // Replace with a RedirectResponse to Gallery

        header("Location: /view");
        return 1;

        // return print_r( $request->files, true );

    } else {

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
    }

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
