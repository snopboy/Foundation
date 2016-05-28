<?php

use Foundation\Framework;
use Illuminate\Container\Container;

use Foundation\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;


Container::setInstance(new Container());
$container = Container::getInstance();

if (! function_exists('app')) {
	/**
	 * Get the available container instance.
	 *
	 * @param  string  $make
	 * @param  array   $parameters
	 * @return mixed|\Illuminate\Foundation\Application
	 */
	function app($make = null, $parameters = array())
	{
		if (is_null($make)) {
			return Container::getInstance();
		}

		return Container::getInstance()->make($make, $parameters);
	}
}

$foundation = Framework::singleton()->registerContainer($container)->Boot();
/*
$routes = new RouteCollection();                        // Router
require(CONF_PATH.'routes.php');                        // Router
$container->instance('http.route_collection', $routes); // Router

$container->instance('http.request', Request::createFromGlobals());  // request
$container->instance('http.request.content', new RequestContext());  // request
$matcher = new UrlMatcher($routes, app('http.request.content'));     // request
$generator = new UrlGenerator($routes, app('http.request.content')); // request

$container->instance('http.matcher', $matcher);
$container->instance('http.generator', $generator);

$container->instance('events.dispatcher', new EventDispatcher());
app('events.dispatcher')->addSubscriber(new RouterListener(app('http.matcher'), new RequestStack()));

$container->instance('http.controller.resolver', new ControllerResolver());
$container->instance('http.kernel', new HttpKernel(app('events.dispatcher'), app('http.controller.resolver')));


$container->instance('app.base_controller', new BaseController());
$response = app('app.base_controller')->forge(app('http.request'), app('http.controller.resolver'), $matcher, $container);


if (!$response instanceof Response) {
	$response = new Response($response);
	$response->setStatusCode(app('app.base_controller')->header);
}
$container->instance('http.response', $response);
app('http.response')->send();

app('http.kernel')->terminate(app('http.request'), app('http.response'));*/