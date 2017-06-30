<?php

/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 29.06.17
 * Time: 12:37
 */
namespace vkBot;
use \GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

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
	
	public function getVkAccessToken()
	{
		$arr = $this->getConfig('vkAuth');
		$login = $arr[0]['user'];
		$password = $arr[0]['password'];
		$client = new Client();
		$res = $client->request("GET",'https://oauth.vk.com/token', [
			RequestOptions::QUERY => ['grant_type' => 'password',
												 'client_id' => $arr[0]['clientId'],
												 'client_secret' =>$arr[0]['clientSecret'],
												 'username' => $login,
												 'password' => $password]])->getBody();
		$res = json_decode($res,true);
		
		return $res['access_token'];
	}
	
	public function getCrons()
	{
		return [
		'Cron/Test.php',
		];
	}
}

