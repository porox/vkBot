<?php
require_once __DIR__ . '/vendor/autoload.php';


$vk = getjump\Vk\Core::getInstance()->apiVersion('5.65')->setToken(\vkBot\App::get()->getVkAccessToken());

$result = $vk->request('newsfeed.search', [
	'q' => 'репост лайк конкурс like розыгрыш приз ',
	'extended'=> '',
	'count' => 100,
])->getResponse();

new \vkBot\Posts\Posts($result);


var_dump($result);