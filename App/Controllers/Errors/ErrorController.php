<?php
namespace App\Controllers\Errors;
use Foundation\Controller\BaseController;

/**
* 
*/
class ErrorController
{
	
	public function notFound()
	{
		$this->header = 404;
		return $this->view->make('errors/404')->render();
	}
	
	public function programError()
	{
		$this->header = 500;
		return $this->view->make('errors/500')->render();
	}
	
	public function serviceUnavailable()
	{
		$this->header = 503;
		return $this->view->make('errors/503')->render();
	}
}