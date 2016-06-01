<?php

namespace Foundation\Http;

use Foundation\Framework;
use Illuminate\Container\Container;;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
* 
*/
class Response
{

	/**
	 * A Framework instance
	 * 
	 * @var \Foundation\Framework
	 */
	public $framework;

	/**
	 * A Response instance
	 * 
	 * @var \Symfony\Component\HttpFoundation\Response
	 */
	public $response;

	/**
	 * Array
	 * 
	 * @var array
	 */
	public $array = array();

	/**
	 * Constructor
	 * 
	 * @param  \Foundation\Framework
	 * @return \Foundation\Http\Router
	 */
	public function __construct(Framework $framework)
	{
		$
	}

	/**
	 * Get all defined routes from Application/Config/routes.php
	 * As an Array and store it in Router::$routes
	 * 
	 * @return \Foundation\Http\Router
	 */
	private function unnamedFunction()
	{
		$this->routes = require(CONF_PATH.'routes.php');
		return $this;
	}
}