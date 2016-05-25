<?php
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
	$system = array('environment' => 'development');
	defined('ENVIRONMENT') OR define('ENVIRONMENT', strtolower($system['environment']));


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