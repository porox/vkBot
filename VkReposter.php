<?php
require_once __DIR__ . '/vendor/autoload.php';

use \Posts\Posts;

$vk = \vkBot\App::get()->getVkInstanse();

sleep(1);
$result = $vk->request('newsfeed.search', [
	'q'        => 'репост лайк конкурс like розыгрыш приз',
	'extended' => '',
	'count'    => 15,
])->getResponse();

$test = new Posts($result);
\vkBot\App::get()->getPDOConnection()->beginTransaction();
try
{
	\vkBot\App::get()->getPDOConnection()->commit();
} catch (Exception $e)
{
	\vkBot\App::get()->getPDOConnection()->rollBack();
}