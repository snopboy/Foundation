<?php

return array(
	'home' => array(
		'url' => '/',
		'controller' => 'Application\Controllers\HomeController::index',
		'params' => array()
	),
	'test' => array(
		'url' => '/test',
		'controller' => 'Application\Controllers\TestController::index',
		'params' => array()
	),
	'testroute' => array(
		'url' => '/test/{route}',
		'controller' => 'Application\Controllers\TestController::index',
		'params' => array('route' => 'testroute')
	)
);
