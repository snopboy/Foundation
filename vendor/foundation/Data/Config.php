<?php

namespace Foundation\Data;


class Config
{


	protected $settings = array();
	protected $protected = array();



	public function __construct()
	{
		if (!$this->getConfig()) throw new \Exception("Error Processing Configuration file", 1);
		$this->settings = $this->getConfig();
	}



	private function getConfig()
	{
		$file = CONF_PATH.'settings.php';
		if (!file_exists($file)) return false;

		return include($file);
	}



	/*public function set($key, $value, $protected = false)
	{
		if (empty($key) || empty($value)) return false;
		if ($protected) $this->protected[$key] = true;
		if (isset($protected[$key])) return false;
		$this->settings[$key] = $value;
	}*/



	public function get($key)
	{
		if (empty($key)) return false;
		if (!isset($this->settings[$key])) return false;
		return $this->settings[$key];
	}
}