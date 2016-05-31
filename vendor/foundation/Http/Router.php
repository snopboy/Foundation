<?php

namespace Foundation\Http;

use Foundation\Framework;
use Illuminate\Container\Container;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
* 
*/
class Router
{

	/**
	 * A Framework instance
	 * 
	 * @var \Foundation\Framework
	 */
	public $framework;

	/**
	 * Array of all registered Routes
	 * 
	 * @var array
	 */
	public $routes = array();

	/**
	 * RouteCollection instance with all registered routes
	 * 
	 * @var \Symfony\Component\Routing\RouteCollection
	 */
	public $router;

	/**
	 * Constructor
	 * 
	 * @param  \Foundation\Framework
	 * @return \Foundation\Http\Router
	 */
	public function __construct(Framework $framework)
	{
		$this->framework = $framework;
		$this->getRouteCollection()->registerRoutes();

		$this->framework->container->instance('http.routes', $this->router);
	}

	/**
	 * Get all defined routes from Application/Config/routes.php
	 * As an Array and store it in Router::$routes
	 * 
	 * @return \Foundation\Http\Router
	 */
	private function getRouteCollection()
	{
		$this->routes = require(CONF_PATH.'routes.php');
		return $this;
	}

	/**
	 * Get all defined routes from Application/Config/routes.php
	 * As an Array and store it in Router::$routes
	 * 
	 * @return \Foundation\Http\Router
	 */
	public function getRoutes()
	{
		return $this->router;
	}

	/**
	 * Register all routes in the RouteCollection and parse the route arrays
	 * TODO: parse routes recursively
	 * 
	 * @return \Foundation\Http\Router
	 */
	private function registerRoutes()
	{
		$this->router = new RouteCollection();
		foreach ($this->routes as $route => $value) {
			$info = array();
			$info['params'] = array();
			foreach ($value['params'] as $param_key => $param_value) {
				$info['params'][$param_key] = $param_value;
			}
			$info['_controller'] = $value['controller'];
			$this->router->add($route, new Route($value['url'],
				$info
			));
		}
		return $this;
	}
}