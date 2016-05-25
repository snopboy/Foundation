<?php

namespace Foundation\Controller;

use Philo\Blade\Blade;
use Illuminate\Container\Container;
use Illuminate\View\Engines\CompilerEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * BaseController is the master controller
 * It's role is to formalize application controllers
 * And wrap controllers with set of tools for the developer' use
 */
class BaseController
{

	/**
	 * Set the header status code of the response
	 * 
	 * @var int
	 */
	public $header = 200;

	/**
	 * Set the Blade View method
	 * 
	 * @var \Philo\Blade\Blade::view()
	 */
	private $view;

	/**
	 * A Blade instance
	 * 
	 * @var \Philo\Blade\Blade
	 */
	private $blade;

	/**
	 * A Request instance
	 * 
	 * @var \Symfony\Component\HttpFoundation\Request 
	 */
	private $request;

	/**
	 * A UrlMatcher instance
	 * 
	 * @var \Symfony\Component\Routing\Matcher\UrlMatcher
	 */
	private $matcher;

	/**
	 * A ControllerResolver instance
	 * 
	 * @var \Symfony\Component\HttpKernel\Controller\ControllerResolver
	 */
	private $resolver;

	/**
	 * A UrlGenerator instance
	 * 
	 * @var \Symfony\Component\Routing\Generator\UrlGenerator
	 */
	private $generator;

	/**
	 * A Container instance
	 * 
	 * @var \Illuminate\Container\Container
	 */
	private $container;

	/**
	 * Set the notFound Controller
	 * 
	 * @var string
	 */
	private $not_found_controller = 'App\Controllers\Errors\ErrorController::notFound';

	/**
	 * Set the programError Controller
	 * 
	 * @var string
	 */
	private $program_error_controller = 'App\Controllers\Errors\ErrorController::programError';

	/**
	 * Set the serviceUnavailable Controller
	 * 
	 * @var string
	 */
	private $service_unavailable_controller = 'App\Controllers\Errors\ErrorController::serviceUnavailable';

	/**
	 * A BaseController singleton instance
	 * 
	 * @var \Foundation\Controller\BaseController
	 */
	protected static $instance = null;

	
	public function __construct()
	{
	}

	/**
	 * Forge a Controller container, pass information to app controllers,
	 * Instantiate new Views (Blade Engine) and direct requests to the right controller
	 * 
	 * @param  \Symfony\Component\HttpFoundation\Request                    $request
	 * @param  \Symfony\Component\HttpKernel\Controller\ControllerResolver  $resolver
	 * @param  \Symfony\Component\Routing\Matcher\UrlMatcher                $matcher
	 * @param  \Illuminate\Container\Container                              $container
	 * @return string
	 */
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

	/**
	 * Set the notFoundController (404 not found)
	 * 
	 * @param  string  $controller
	 * @return \Foundation\Controller\BaseController
	 */
	public function setNotFoundController($controller)
	{
		$this->not_found_controller = $controller;
		return $this;
	}

	/**
	 * Set the errorController (500 internal server error)
	 * 
	 * @param  string  $controller
	 * @return \Foundation\Controller\BaseController
	 */
	public function setErrorController($controller)
	{
		$this->program_error_controller = $controller;
		return $this;
	}

	/**
	 * Set the unavailableController (503 service unavailable)
	 * 
	 * @param  string  $controller
	 * @return \Foundation\Controller\BaseController
	 */
	public function setUnavailableController($controller)
	{
		$this->service_unavailable_controller = $controller;
		return $this;
	}

	/**
	 * Match app controller to the current request, dispatch the controller,
	 * Add global properties to the controller, dispatch notFoundController
	 * if no Route was found, And serviceUnavailableController if there was an error
	 * In the Controller
	 * 
	 * @return string
	 */
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

	/**
	 * Dispatch a notFound Controller
	 * 
	 * @return string
	 */
	private function notFound()
	{
		$controller = array();
		list($controller[0], $controller[1]) = explode('::', $this->not_found_controller);

		$controller[0] = new $controller[0]();

		$controller[0]->container = $this->container;
		$controller[0]->generator = $this->generator;
		$controller[0]->blade = $this->blade;
		$controller[0]->view = $this->view;
		$arguments = array();

		$response = call_user_func_array(array($controller[0], $controller[1]), $arguments);
		$this->header = 404;

		return $response;
	}

	/**
	 * Dispatch a programError Controller
	 * 
	 * @return string
	 */
	private function programError()
	{
		$controller = array();
		list($controller[0], $controller[1]) = explode('::', $this->program_error_controller);
		$controller[0] = new $controller[0]();

		$controller[0]->container = $this->container;
		$controller[0]->generator = $this->generator;
		$controller[0]->blade = $this->blade;
		$controller[0]->view = $this->view;

		$arguments = array();
		$response = call_user_func_array($controller, $arguments);
		$this->header = 500;

		return $response;
	}

	/**
	 * Dispatch a serviceUnavaialble Controller
	 * 
	 * @return string
	 */
	private function serviceUnavailable()
	{
		$controller = array();
		list($controller[0], $controller[1]) = explode('::', $this->service_unavailable_controller);
		$controller[0] = new $controller[0]();

		$controller[0]->container = $this->container;
		$controller[0]->generator = $this->generator;
		$controller[0]->blade = $this->blade;
		$controller[0]->view = $this->view;

		$arguments = array();
		$response = call_user_func_array($controller, $arguments);
		$this->header = 503;

		return $response;
	}
}