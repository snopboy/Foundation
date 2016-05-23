<?php

use Symfony\Component\Routing\Route;

$routes->add('home', new Route('/',
	array(
		'who' => 'World',
		'_controller' => 'App\Controllers\HomeController::index'
	)
));
$routes->add('test', new Route('/test',
	array('_controller' => 'App\Controllers\TestController::index')
));