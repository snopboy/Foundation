<?php

namespace Foundation\Http;

use Foundation\Data\Config;
use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
* 
*/
class Request
{

	public $proxies = '*';
	public $request;
	public $context;
	public $matcher;
	public $generator;


	public function __construct(RouteCollection $routes)
	{
		$this->createFromGlobals()->getContext()->matchRequest($routes)
			 ->generateUrl($routes)->setTrustedProxies();
		return $this;
	}


	public function getMatcher()
	{
		return $this->matcher;
	}


	private function setTrustedProxies()
	{
		$config_proxy = Config::get('proxy');
		if (is_array($config_proxy)) {
			$this->proxies = $config_proxy;
		}
		if (ENVIRONMENT == 'development') {
			$this->proxies = array('127.0.0.1', 'fe80::1', '::1');
		}
		if ($this->proxies === '*') {
			$this->proxies = array($this->request->getClientIp());
		}
		Request::setTrustedProxies($this->proxies);
		return $this;
	}


	private function createFromGlobals()
	{
		$this->request = Request::createFromGlobals();
		return $this;
	}


	private function getContext()
	{
		$this->context = new RequestContext();
		return $this;
	}


	private function matchRequest($routes)
	{
		$this->matcher = new UrlMatcher($routes, $this->context);
		return $this;
	}


	private function generateUrl($routes)
	{
		$this->generator = new UrlGenerator($routes, $this->context);
		return $this;
	}
}