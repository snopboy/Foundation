<?php
//$container->instance('http.kernel', new HttpKernel(app('events.dispatcher'), app('http.controller.resolver')));

//app('http.kernel')->terminate(app('http.request'), app('http.response'));

namespace Foundation\Http;

use Foundation\Framework;
use Illuminate\Container\Container;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

/**
* 
*/
class Kernel
{
	public $framework;
	
	public function __construct(Framework $framework)
	{
		$this->framework = $framework;
	}
}