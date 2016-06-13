<?php

return array(
	'home' => array(
		'url' => '/',
		'controller' => 'Application\Controllers\HomeController::index',
		'params' => array('name' => 'Snopboy')
	),
	'test' => array(
		'url' => '/test',
		'controller' => 'Application\Controllers\TestController::index',
		'params' => array()
	),
	'api' => array(
		'url' => '/api',
		'controller' => 'Application\Controllers\TestController::api',
		'params' => array('name' => 'Json API')
	),
	'redirect' => array(
		'url' => '/redirect',
		'controller' => 'Application\Controllers\TestController::redirect',
		'params' => array('url' => 'http://forum.ragezone.com/f425')
	),
);
