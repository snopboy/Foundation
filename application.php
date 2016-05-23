<?php

use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;


$container = new Container();
Container::setInstance($container);
$container = Container::getInstance();

if (! function_exists('app')) {
	/**
	 * Get the available container instance.
	 *
	 * @param  string  $make
	 * @param  array   $parameters
	 * @return mixed|\Illuminate\Foundation\Application
	 */
	function app($make = null, $parameters = [])
	{
		if (is_null($make)) {
			return Container::getInstance();
		}

		return Container::getInstance()->make($make, $parameters);
	}
}

$routes = new RouteCollection();
require(CONF_PATH.'routes.php');
$container->instance('http.route_collection', $routes);

$request = Request::createFromGlobals();
$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);
$generator = new UrlGenerator($routes, $context);

$container->instance('http.matcher', $matcher);
$container->instance('http.generator', $generator);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));
$container->instance('events.dispatcher', $dispatcher);

$resolver = new ControllerResolver();
$kernel   = new HttpKernel($dispatcher, $resolver);
$container->instance('http.kernel', $kernel);


$base_controller = Foundation\Controller\BaseController::singleton();
$container->instance('app.base_controller', $base_controller);
// no need for all those args, the container will suffice
$response = $base_controller->forge($request, $resolver, $matcher, $container);


if (!$response instanceof Response) {
	$response = new Response($response);
	$response->setStatusCode($base_controller->header);
}

$container->instance('http.response', $response);
$response->send();

$kernel->terminate($request, $response);