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
    private $clientId;
    private $clientSecret;
    private $login;
    private $password;
    private $token = null;
    private $vkInstanse = null;
    
    public function __construct($clientId,$clientSecret,$login,$password)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->login = $login;
        $this->password = $password;
    
    }
    
    private function getVkAccessToken()
    {
        if (is_null($this->token))
        {
            $client      = new Client();
            $res         = $client->request("GET", 'https://oauth.vk.com/token', [
                RequestOptions::QUERY => [
                    'grant_type'    => 'password',
                    'client_id'     => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'username'      => $this->login,
                    'password'      => $this->password
                ]
            ])->getBody();
            $res         = json_decode($res, true);
            $this->token = $res['access_token'];
        }
        
        
        return $this->token;
    }
    
    /**
     * @return VkApi|null
     */
    public function getVkInstanse()
    {
        if (is_null($this->vkInstanse))
        {
            $token            = $this->getVkAccessToken();
            $this->vkInstanse = VkApi::getInstance()->apiVersion('5.65')->setToken($token);
        }
        
        return $this->vkInstanse;
    }
    
    public function getToken()
    {
        return $this->token;
    }
}