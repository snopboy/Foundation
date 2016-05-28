<?php


//$routes = new RouteCollection();
//require(CONF_PATH.'routes.php');
//$container->instance('http.route_collection', $routes);

namespace Foundation\Http;

use Foundation\Framework;
use Illuminate\Container\Container;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
* 
*/
class Router
{

	public $framework;
	public $routes = array();
	public $router;
	
	public function __construct(Framework $framework)
	{
		$this->framework = $framework;
		$this->getRouteCollection()->registerRoutes();

		$routes = $this->routes;
		$framework->container->singleton('http.routes', $this->router);
		//var_dump($this->router);
	}
	
	private function getRouteCollection()
	{
		$this->routes = require(CONF_PATH.'routes.php');
		return $this;
	}
	
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