<?php

require_once('controllers/perfiles.php');

$app->get('/', function() use ($app) 
{
 	return  'default controller';
});