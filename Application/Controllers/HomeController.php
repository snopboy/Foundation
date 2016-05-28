<?php
namespace Application\Controllers;

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

		// Add a ServiceProvider for Flashes and Messages
		$_SESSION['flashes'] = array(
			'welcome' => array(
				'name' => 'welcome',
				'type' => 'success',
				'message' => sprintf('Welcome back, %s!', $who)
			),
			'mood' => array(
				'name' => 'mood',
				'type' => 'primary',
				'message' => sprintf('How are you, %s?', $who)
			),
			'rage' => array(
				'name' => 'rage',
				'type' => 'danger',
				'message' => sprintf('Fuck you, %s!', $who)
			),
		);

		$this->header = 200;
		return $this->view->make('home', $data)->render();
	}
}