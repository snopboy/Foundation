<?php


//$container->instance('events.dispatcher', new EventDispatcher());
//app('events.dispatcher')->addSubscriber(new RouterListener(app('http.matcher'), new RequestStack()));


namespace Foundation\Events;

use Foundation\Framework;
use Illuminate\Container\Container;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\RouterListener;

/**
* 
*/
class Dispatcher
{

	public $framework;
	public $dispatcher;
	public $route_listener;
	public $request_stack;
	
	public function __construct(UrlMatcher $matcher)
	{
		$this->dispatcher = new EventDispatcher();
		$this->request_stack = new RequestStack();
		$this->route_listener = new RouterListener($matcher, $this->request_stack);
		$this->subscribe($this->route_listener);
		return $this;
	}
	
	public function subscribe($service)
	{
		$this->dispatcher->addSubscriber($service);
		return $this;
	}
	
	public function getDispatcher()
	{
		return $this->dispatcher;
	}
}