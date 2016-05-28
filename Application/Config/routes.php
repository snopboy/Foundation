<?php

return array(
	'home' => array(
		'url' => '/',
		'controller' => 'Application\Controllers\HomeController::index',
		'params' => array('who' => 'World')
	),
	'test' => array(
		'url' => '/test',
		'controller' => 'Application\Controllers\TestController::index',
		'params' => array()
	)
);
