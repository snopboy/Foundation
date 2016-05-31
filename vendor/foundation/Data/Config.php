<?php

namespace Foundation\Data;
use \Exception;


class Config
{

	protected static $settings = array();
	protected static $protected = array();


	public static function populate()
	{
		if (!self::getConfig() || !is_array(self::getConfig())) throw new Exception("Error Processing Configuration file", 1);
		self::$settings = self::getConfig();
	}


	private static function getConfig()
	{
		$file = CONF_PATH.'settings.php';
		if (!file_exists($file)) return false;
		return include($file);
	}


	public static function exist($key)
	{
		return isset(static::$settings[$key]);
	}


	public static function get($key, $default = null)
	{
		if (!static::exist($key)) return $default;
		return static::$settings[$key];
	}


	public static function add($key, $value = null)
	{
		if (static::exist($key)) return false;
		return static::$settings[$key] = $value;
	}


	public static function addBulk($settings = array())
	{
		return array_merge(static::$settings, $settings);
	}


	public static function set($key, $value = null)
	{
		return static::$settings[$key] = $value;
	}


	public static function delete($key)
	{
		if (!static::exist($key)) return true;
		unset(static::$settings[$key]);
		return true;
	}
}