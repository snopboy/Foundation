<?php

/**
 * $container->instance('http.request', Request::createFromGlobals());
 * $container->instance('http.request.content', new RequestContext());
 * $matcher = new UrlMatcher($routes, app('http.request.content'));
 * $generator = new UrlGenerator($routes, app('http.request.content'));
 */

namespace Foundation\Http;

use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
* 
*/
class Request
{
	
	public function __construct(Framework $framework)
	{
		# code...
	}
}