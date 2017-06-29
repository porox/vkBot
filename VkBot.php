<?php
require_once __DIR__ . '/autoloader.php';

use \vkBot\App;

$accessToken = App::get()->getVkAccessToken();

$vk = getjump\Vk\Core::getInstance()->apiVersion('5.65')->setToken($accessToken);

$posts = $vk->request('wall.get', [
	'owner_id' =>'',
	//'domain' => "alimoney",
	'domain'=>'besplatno.zarepost',
	'offset' => 0,
	'count'  => 25
])->getResponse();


$parseAttach = function($attachments){
	$result ="";
	foreach ($attachments as $attachment)
	{
		$attachment = (array) $attachment;
		$type = $attachment['type'];
		if (!in_array($type,['link','page']))
		{
			$attachment[$type] =(array) $attachment[$type];
			$result .= $type.$attachment[$type]['owner_id']."_".$attachment[$type]['id'].",";
			if (!isset($attachment[$type]['owner_id']))
			{
				var_dump($attachment);
			}
		}
		
	}
	return substr($result,0,-1);
};
$result = null;
$time = new DateTime('now');

foreach($posts as $post)
{
	if (isset($post->copy_history))
	{
		$post = $post->copy_history[0];
	}
	
	try
	{
		$time->add(new DateInterval('PT'.rand(5,58)."S"));
		$timestamp = $time->getTimestamp();
		$post->text =preg_replace('/\[club[0-9]*\|(.*)\]/',"[club34915732| Лайк репост]",$post->text);
		$params	=[
			'owner_id'             => '-34915732',
			'friends_only'         => 0,
			'from_group'           => 1,
			'message'              => $post->text ? $post->text : "",
			'attachments'          => isset($post->attachments) ? $parseAttach($post->attachments) : "",
			'services'             => "",
			'signed'               => 0,
			'publish_date'         => $timestamp,
			'lat'                  => 0,
			'long'                 => 0,
			'place_id'             => '',
			'post_id'              => '',
			//'guid'                 => ,
			'mark_as_ads'          => 0,
		];
		$tmp = $vk->request('wall.post', $params)->getResponse();
		echo "Post ".$post->id." export  published :".$time->format('Y-m-d H:i:s').PHP_EOL;
		
		
	}
	catch (Exception $e)
	{
		echo "query was down".PHP_EOL;
		var_dump($e->getCode());
		var_dump($e->getMessage());
		if ($e->getCode() == 214)
		{
			//throw new Exception('Привышен лимит публикаций 50 постов в день');
		}
	}
	sleep(rand(1,3));
	$time->add(new DateInterval('PT'.rand(10,35).'M'.rand(1,58)."S"));
}
?>
