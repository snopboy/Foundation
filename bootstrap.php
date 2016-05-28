<?php


/*
|--------------------------------------------------------------------------
|	SETTINGS
|--------------------------------------------------------------------------
|
|	Register conveniece environment constants
|
*/
	// directory separator
	defined('DS') OR define('DS', DIRECTORY_SEPARATOR);

	// public directory path
	defined('PUBLIC_DIR') OR define('PUBLIC_DIR', getcwd() . DS);

	// root directory path
	defined('BASE_PATH') OR define('BASE_PATH', dirname(PUBLIC_DIR) . DS);

	// application directory path
	defined('APP') OR define('APP' , BASE_PATH . 'Application' . DS);

	// vendor directory path
	defined('VENDOR') OR define('VENDOR', BASE_PATH . 'vendor' . DS);


	// config directory path
	defined('CONF_PATH') OR define('CONF_PATH', APP . 'Config' . DS);

	// controllers directory path
	defined('CONTROLLER_PATH') OR define('CONTROLLER_PATH', APP . 'Controllers' . DS);

	// models directory path
	defined('MODEL_PATH') OR define('MODEL_PATH', APP . 'Models' . DS);

	// views directory path
	defined('VIEW_PATH') OR define('VIEW_PATH', APP . 'Views' . DS);

	// cache directory path
	defined('CACHE_PATH') OR define('CACHE_PATH', APP . 'Cache' . DS);


/*
|--------------------------------------------------------------------------
|	AUTOLOADER & APPLICATION
|--------------------------------------------------------------------------
|
|	Require once the autoloader of Composer
|
*/
	require_once(VENDOR.'autoload.php');
	require_once(BASE_PATH.'application.php');