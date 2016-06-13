<?php
namespace Application\Controllers;

/**
*
*/
class HomeController
{

	public function index($name)
	{
		$data = array(
			'name' => $name
		);

		// Add a ServiceProvider for Flashes and Messages
		$_SESSION['flashes'] = array(
			'welcome' => array(
				'name' => 'welcome',
				'type' => 'success',
				'message' => sprintf('Welcome back, %s!', $name)
			),
			'mood' => array(
				'name' => 'mood',
				'type' => 'primary',
				'message' => sprintf('How are you, %s?', $name)
			),
			'rage' => array(
				'name' => 'rage',
				'type' => 'danger',
				'message' => sprintf('Fuck you, %s!', $name)
			),
		);

		$this->header = 200;
		return $this->view->make('home', $data)->render();
	}

}
