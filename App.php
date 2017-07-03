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
	 * @var \PDO
	 */
	private $connectionDB;
	
	/**
	 * @var string
	 */
	private $confFile = 'config.json';
	
	/**
	 * @var null|App
	 */
	private static $instance = null;
	
	private $token =null;
	
	
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
	private function getConfig($key = null)
	{
		if (is_null($this->config))
		{
			$this->config = $this->initConfig();
		}
		return is_null($key) ? $this->config : (isset($this->config[$key]) ? $this->config[$key] : []);
	}
	
	public function getPDOConnection()
	{
		if (!isset($this->connectionDB))
		{
			$settings = $this->getConfig('dbOptions');
			$this->connectionDB = new \PDO($settings['connection'].':host='.$settings['host'].';port='.$settings['port'].";dbname=".$settings['dbName']);
		}
		return $this->connectionDB;
		
	}
	
	public function getVkAccessToken()
	{
		if (is_null($this->token))
		{
			$arr = $this->getConfig('vkAuth');
			$client = new Client();
			$res = $client->request("GET",'https://oauth.vk.com/token', [
				RequestOptions::QUERY => ['grant_type' => 'password',
										  'client_id' => $arr[0]['clientId'],
										  'client_secret' =>$arr[0]['clientSecret'],
										  'username' => $arr[0]['user'],
										  'password' => $arr[0]['password']]])->getBody();
			$res = json_decode($res,true);
			$this->token =$res['access_token'];
		}
		
		
		return $this->token;
	}
	
	public function getCrons()
	{
		return [
		'Cron/Test.php',
		];
	}
}

