<?php
namespace App\Controllers;

/**
* 
*/
class HomeController
{
	
	public function index($who)
	{
		$data = array(
			'name' => $who
		);
		$flashes = array (
			'rage' => array(
				'name' => 'rage',
				'type' => 'danger',
				'message' => sprintf('Fuck you, %s!', $who)
			),
		);
		$this->header = 200;
		return $this->view->make('home', $data)->with('flash', $flashes)->render();
	}
}