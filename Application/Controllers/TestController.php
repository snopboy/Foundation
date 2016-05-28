<?php
namespace Application\Controllers;
use Foundation\Controller\BaseController;

/**
* 
*/
class TestController
{
	
	// non existent args or an \Exception will be catched
	// and 503 controller will be called
	public function index(/*$nonexistent*/)
	{
		//$this->header = 200; // won werk
		//throw new \Exception;
		return $this->view->make('home')->render(); // naw dat won werk
	}
}