<?php

require_once('controllers/perfiles.php');
require_once('controllers/usuarios.php');
require_once('controllers/images.php');

$app->get('/', function() use ($app) 
{
 	return  'default controller';
});