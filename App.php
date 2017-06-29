<?php

/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 29.06.17
 * Time: 12:37
 */
namespace vkBot;

/**
 * Class App
 *
 * @package vkBot
 */
class App
{
	/**
	 * App constructor.
	 */
	private  function __construct() {}
	
	/**
	 *
	 */
	private function __clone() {}
	
	
	/**
	 * @var null|array
	 */
	private $config = null;
	
	/**
	 * @var string
	 */
	private $confFile = 'config.json';
	
	/**
	 * @var null|App
	 */
	private static $instance = null;
	
	
	/**
	 * @return App
	 */
	public  static function get ()
	{
		
		if (is_null(self::$instance))
		{
			$class =get_called_class();
		   	self::$instance = new  $class;
		}
		return self::$instance;
	}
	
	/**
	 * @return mixed|string
	 * @throws \Exception
	 */
	private  function initConfig()
	{
		$filePath = __DIR__.'/'.$this->confFile;
		if (file_exists($filePath))
		{
			$json = file_get_contents($filePath);
			$json = json_decode($json,true);
		}
		else
		{
			throw new \Exception("Config file: ".$filePath." not exist!!");
		}
		return $json;
	}
	
	/**
	 * @param null|string $key
	 *
	 * @return array|mixed|null|string
	 */
	public function getConfig($key = null)
	{
		if (is_null($this->config))
		{
			$this->config = $this->initConfig();
		}
		return is_null($key) ? $this->config : (isset($this->config[$key]) ? $this->config[$key] : []);
	}
	
	/**
	 *
	 */
	public function changeConfig()
	{
		$this->config = "changedConf";
	}
}

var_dump(App::get()->getConfig('vkOptions'));
App::get()->changeConfig();
var_dump(App::get()->getConfig('vkOptions'));
