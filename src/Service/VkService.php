<?php
/**
 * Created by PhpStorm.
 * User: y.dombrovsky
 * Date: 30.01.2018
 * Time: 13:59
 */

namespace App\Service;

use \GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use getjump\Vk\Core as VkApi;

class VkService
{
    private $clientSecret;
    private $apiVersion;
    private $token = null;
    private $vkInstanse = null;
    
    public function __construct(string  $clientId,string $clientSecret,$apiVersion='5.65')
    {
        $this->clientId = $clientId;
        $this->apiVersion = $apiVersion;
        $this->clientSecret = $clientSecret;
	}
    
    /**
     * @return VkApi|null
     */
    public function getVkInstanse($token)
    {
    	if (is_null($token))
		{
			throw new \Exception('Передан пустой token');
		}
    	if ($token != $this->token)
		{
			$this->token = $token;
			$this->vkInstanse = VkApi::getInstance()->apiVersion($this->apiVersion)->setToken($this->token);
		}
        return $this->vkInstanse;
    }
    
    public function getToken()
    {
        return $this->token;
    }
}