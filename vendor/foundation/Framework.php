<?php

namespace Foundation;

use Foundation\Http\Kernel;
use Foundation\Http\Router;
use Foundation\Http\Request;
use Foundation\Http\Response;
use Foundation\Events\Dispatcher;
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
		$this->container->singleton('http.router', function()
		{
			return new Router($this);
		});
		$this->container->singleton('http.request', function()
		{
			return new Request($this);
		});
		$this->container->make('http.router');

		//$this->container->singleton('http.kernel', function()
		//{
		//	return new Kernel($this);
		//});
		//var_dump($this->container->make('http.kernel'));
	}

}