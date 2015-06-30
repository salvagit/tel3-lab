<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

// http://imagine.readthedocs.org/en/latest/
$app->get('/images', function() use ($app) 
{
    $imagine = new Imagine\Gd\Imagine();

	$size    = new Imagine\Image\Box(40, 40);

	$mode    = Imagine\Image\ImageInterface::THUMBNAIL_INSET;
	// or
	$mode    = Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
/*
	$imagine->open('/path/to/large_image.jpg')
	    ->thumbnail($size, $mode)
	    ->save('/path/to/thumbnail.png')
	;
*/
    return var_dump($imagine);
});

$app->get('/img/{name}', function( $name, Request $request ) use ( $app ) {

    if ( !file_exists( $app['upload_folder'] . '/' . $name ) )
    {
        throw new \Exception( 'File not found' );
    }

    $out = new BinaryFileResponse($app['upload_folder'] . '/' . $name );

    return $out;
});

$app->get('/view', function() use ( $app ) {

    $images = glob($app['upload_folder'] . '/*');

    $out = '';

    foreach( $images as $img )
    {
        $out .= '<a href="/edit/'. basename($img) .'/small"><img src="/assets/uploads/' . basename($img) . '" />';
    }

    return $out;
});

$app->get('/edit/{name}/{size}', function( $name, $size, Request $request ) use ( $app ) {
    $prefix = $app['upload_folder'].'/';
    $full_name = $prefix . $name;

    $thumb_name = '';
    $thumb_width = 320;
    $thumb_height = 240;

    if ( !file_exists( $full_name ) )
    {
        throw new \Exception( 'File not found' );
    }

    switch ( $size )
    {
    default:
    case 'small':
        $thumb_name = $prefix . 'small_' . $name . '.jpg';
        $thumb_width = 320;
        $thumb_height = 240;
        break;

    case 'medium':
        $thumb_name = $prefix . 'medium_' . $name . '.jpg';
        $thumb_width = 1024;
        $thumb_height = 768;
        break;
    }

    $out = null;

    if ( 'original' == $size )
    {
        $out = new BinaryFileResponse($full_name);
    }
    else
    {
        if ( !file_exists( $thumb_name ) )
        {
            $app['imagine']->open($full_name)
                ->thumbnail(
                    new Imagine\Image\Box($thumb_width,$thumb_height), 
                    Imagine\Image\ImageInterface::THUMBNAIL_INSET)
                ->save($thumb_name);
        }

        $out = new BinaryFileResponse($thumb_name);
    }

    return $out;
})->value('size', 'small');