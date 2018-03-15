<?php

namespace App\Controller;

use App\Service\PostParserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class MainController extends Controller
{
    /**
     * @Route("/auth/by/{user}/{password}", name="main")
     */
    public function authByLoginPassword($user, $password)
    {
		$client      = new Client();
		$res         = $client->request("GET", 'https://oauth.vk.com/token', [
			RequestOptions::QUERY => [
				'grant_type'    => 'password',
				'client_id'     => '2274003',
				'client_secret' => 'hHbZxrka2uZ6jB1inYsH',
				'username'      => $user,
				'password'      => $password
			]
		])->getBody();
        
        return new Response($res,200);
    }
	/**
	 * @Route("/authByRedirect", name="auth")
	 */
	public function authByRedirect()
	{
		// replace this line with your own code!
		/**
		 * @var PostParserService $postParser
		 */
		$vkService = $this->container->get('App\Service\VkService');
		$auth = \getjump\Vk\Auth::getInstance();
		$auth->setAppId('2274003')->setScope('groups,offline')->setSecret('hHbZxrka2uZ6jB1inYsH'); // SETTING ENV
		if (isset($_GET['code']))
		{
			$token = $auth->startCallback();
			return $this->json($token);
		}
		
		return $this->redirect($auth->getUrl());
    }
}
