<?php
// Add a class to handle Sessions
session_start();

/*
|--------------------------------------------------------------------------
|	APPLICATION START TIME & MEMORY
|--------------------------------------------------------------------------
|
|	Define our application's START time and START memory usage.
|
*/
	defined('START_TIME')   OR define('START_TIME', microtime(true));
	defined('START_MEMORY') OR define('START_MEMORY', memory_get_usage());


/*
|--------------------------------------------------------------------------
|	DEFINE CURRENT ENVIRONMENT
|--------------------------------------------------------------------------
|
|	development: If the application is in development phase.
|	testing: If the application is being tested live.
|	production: If the application is in production mode.
|
*/
	define('ENVIRONMENT', 'development');

	$devAllowed = array('127.0.0.1', 'fe80::1', '::1');
	if (ENVIRONMENT == 'development') {
		if (!in_array(@$_SERVER['REMOTE_ADDR'], $devAllowed)) {
			header('HTTP/1.0 403 Forbidden');
			exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
		}
	}


/*
|--------------------------------------------------------------------------
|	Turn the lights on
|--------------------------------------------------------------------------
|
|	Require Autoload file that registers our Environment vars, requires
|	Composer's Autoloader and start our application
|
*/
	require_once(dirname(getcwd()).'/bootstrap.php');