<?php

namespace Foundation\Controller;

use Philo\Blade\Blade;
use Illuminate\Container\Container;
use Illuminate\View\Engines\CompilerEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
* 
*/
class BaseController
{

	public $header = 200;
	private $view;
	private $blade;
	private $request;
	private $matcher;
	private $resolver;
	private $generator;
	private $container;
	private $not_found_controller = 'App\Controllers\Errors\ErrorController::notFound';
	private $program_error_controller = 'App\Controllers\Errors\ErrorController::programError';
	private $service_unavailable_controller = 'App\Controllers\Errors\ErrorController::serviceUnavailable';
	protected static $instance = null;
	
	public function __construct()
	{
	}

	public function forge(Request $request, ControllerResolver $resolver, UrlMatcher $matcher, Container $container)
	{
		$this->request   = $request;
		$this->resolver  = $resolver;
		$this->matcher   = $matcher;
		$this->container = $container;
		$this->generator = $this->container->make('http.generator');
		$this->blade     = new Blade(VIEW_PATH, CACHE_PATH);
		$this->view      = $this->blade->view();
		$this->container->instance('view.blade', $this->blade);
		$this->container->instance('view.blade.view', $this->view);

		return $this->callController();
	}

	public static function singleton()
	{
		if (self::$instance == null) self::$instance = new self();
		return self::$instance;
	}

	public static function setNotFoundController($controller)
	{
		$this->not_found_controller = $controller;
		return $this;
	}

	public static function setErrorController($controller)
	{
		$this->program_error_controller = $controller;
		return $this;
	}

	public static function setUnavailableController($controller)
	{
		$this->service_unavailable_controller = $controller;
		return $this;
	}

	public function callController()
	{
		try {
			$this->matcher->getContext()->fromRequest($this->request);
			$this->request->attributes->add(
				$this->matcher->match($this->request->getPathInfo())
			);

			$controller = $this->resolver->getController($this->request);
			$arguments  = $this->resolver->getArguments($this->request, $controller);

			$controller[0]->container = $this->container;
			$controller[0]->generator = $this->generator;
			$controller[0]->blade = $this->blade;
			$controller[0]->view  = $this->view;

			$response = call_user_func_array($controller, $arguments);
			if (isset($controller[0]->header)) {
				$this->header = $controller[0]->header;
			}
		}
		catch (ResourceNotFoundException $e) {
			$response = $this->notFound();
		}
		catch (\Exception $e) {
			$response = $this->serviceUnavailable();
		}

		return $response;
	}

	private function notFound()
	{
		$controller = array('');
		list($controller[0], $controller[1]) = explode('::', $this->not_found_controller);

		$controller[0] = new $controller[0]();

		$controller[0]->container = $this->container;
		$controller[0]->generator = $this->generator;
		$controller[0]->blade = $this->blade;
		$controller[0]->view = $this->view;
		$arguments = array('');

		$response = call_user_func_array(array($controller[0], $controller[1]), $arguments);
		$this->header = 404;

		return $response;
	}

	private function programError()
	{
		$controller = array('');
		list($controller[0], $controller[1]) = explode('::', $this->program_error_controller);
		$controller[0] = new $controller[0]();

		$controller[0]->container = $this->container;
		$controller[0]->generator = $this->generator;
		$controller[0]->blade = $this->blade;
		$controller[0]->view = $this->view;

		$arguments = array('');
		$response = call_user_func_array($controller, $arguments);
		$this->header = 500;

		return $response;
	}

	private function serviceUnavailable()
	{
		$controller = array('');
		list($controller[0], $controller[1]) = explode('::', $this->service_unavailable_controller);
		$controller[0] = new $controller[0]();

		$controller[0]->container = $this->container;
		$controller[0]->generator = $this->generator;
		$controller[0]->blade = $this->blade;
		$controller[0]->view = $this->view;

		$arguments = array('');
		$response = call_user_func_array($controller, $arguments);
		$this->header = 503;

		return $response;
	}
}