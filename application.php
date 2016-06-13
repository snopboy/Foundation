<?php

use Foundation\Framework;
use Illuminate\Container\Container;


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

Framework::singleton()->registerContainer($container)->Boot();
