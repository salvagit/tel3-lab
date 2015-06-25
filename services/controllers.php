<?php

require_once('controllers/perfiles.php');
require_once('controllers/usuarios.php');

$app->get('/', function() use ($app) 
{
 	return  'default controller';
});