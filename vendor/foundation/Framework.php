<?php

namespace Foundation;

use Foundation\Data\Config;
use Foundation\Http\Kernel;
use Illuminate\Container\Container;

/**
* 
*/
class Framework
{

	public static $instance = null;
	public $container;
	public $dispatcher;
	public $router;
	public $request;
	public $response;
	public $kernel;
	
	protected function __construct()
	{
		# code...
	}
	
	public static function singleton()
	{
		if (self::$instance == null) self::$instance = new self();
		return self::$instance;
	}
	
	public function registerContainer(Container $container)
	{
		$this->container = $container;
		return $this;
	}
	
	public function Boot()
	{
		Config::populate();
		$this->container->singleton('http.kernel', function()
		{
			return new Kernel($this);
		});
		$this->container->make('http.kernel');

		//$this->container->singleton('http.kernel', function()
		//{
		//	return new Kernel($this);
		//});
		//var_dump($this->container->make('http.kernel'));
	}

}