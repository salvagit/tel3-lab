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

$app->get('/perfiles', function(Request $request) use ($app) 
{
    return $app['twig']->render('perfiles/perfiles.twig');
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
