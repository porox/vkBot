<?php
require_once __DIR__ . '/vendor/autoload.php';

$email = "";
$pass  = '';

$client = new \GuzzleHttp\Client();
$res = $client->request("GET",'https://oauth.vk.com/token', [
	GuzzleHttp\RequestOptions::QUERY => ['grant_type' => 'password',
												   'client_id' => 2274003,
												   'client_secret' =>"hHbZxrka2uZ6jB1inYsH",
												   'username' => $email,
												   'password' => $pass]])->getBody();
$res = json_decode($res,true);

$accessToken = $res['access_token'];
$userId=$res['user_id'];


$vk = getjump\Vk\Core::getInstance()->apiVersion('5.65')->setToken($accessToken);

$result = $vk->request('newsfeed.search', [
	'q' => 'репост лайк конкурс ',
	'extended'=> '',
	'count' => 100,
])->getResponse();

var_dump($result);