<?php

namespace Foundation\Http;

use Foundation\Framework;
use Foundation\Http\Router;
use Foundation\Http\Request;
//use Foundation\Http\Response;
use Foundation\Events\Dispatcher;
use Foundation\Controller\BaseController;
use Illuminate\Container\Container;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
* 
*/
class Kernel
{
	public $framework;
	public $container;
	public $dispatcher;
	public $request;
	public $matcher;
	public $router;
	public $response;
	public $resolver;
	public $content;
	
	public function __construct(Framework $framework)
	{
		$this->framework = $framework;
		$this->container = $this->framework->container;

		$this->container->instance('http.router', new Router($this->framework));
		$this->router = $this->container->make('http.router');

		$this->container->instance('http.request', $this->registerRequest());
		$this->matcher = $this->request->getMatcher();
		$this->container->instance('http.generator', $this->container->make('http.request')->generator);
		$this->dispatcher = new Dispatcher($this->matcher);
		$this->container->instance('events.dispatcher', $this->dispatcher);
		$this->container->instance('controller.resolver', new ControllerResolver());
		$this->container->instance('http.kernel', new HttpKernel(
			$this->container->make('events.dispatcher')->getDispatcher(),
			$this->container->make('controller.resolver'))
		);

		$this->base_controller = new BaseController();

		$this->content = $this->base_controller->forge(
			$this->container->make('http.request')->request,
			$this->container->make('controller.resolver'),
			$this->container->make('http.request')->getMatcher(),
			$this->container
		);

		// move to \Foundation\Http\Response
		if (!$this->response instanceof Response) {
			$this->response = new Response($this->content);
			$this->response->setStatusCode($this->base_controller->header);
		}
		$this->response->send();

		$this->container->make('http.kernel')->terminate(
			$this->container->make('http.request')->request,
			$this->response
		);

		//var_dump($this->request->request->getPathInfo());
	}

	/**
	 * Get all defined routes from Application/Config/routes.php
	 * As an Array and store it in Router::$routes
	 * 
	 * @return \Foundation\Http\Router
	 */
	private function registerRequest()
	{
		return $this->request = new Request($this->router->getRoutes());
		//$this->request->request->getClientIp()
		//SymfonyRequest::getTrustedProxies()
	}

	/**
	 * Get all defined routes from Application/Config/routes.php
	 * As an Array and store it in Router::$routes
	 * 
	 * @return \Foundation\Http\Router
	 */
	private function registerResponse()
	{
		//return $this->response = new Response();
	}
}