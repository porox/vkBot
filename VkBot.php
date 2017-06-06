<?php
require_once __DIR__ . '/vendor/autoload.php';

$email = "";
$pass  = '';

$page  = file_get_contents("https://oauth.vk.com/token?grant_type=password&client_id=2274003&client_secret=hHbZxrka2uZ6jB1inYsH&username=" . $email . "&password=" . $pass);
$page  = preg_split("/\"/", $page);
//var_dump($page);
$accessToken = $page[3];

//$auth = getjump\Vk\Auth::getInstance()->setSecret("hHbZxrka2uZ6jB1inYsH")->setAppId(2274003);
//$token = $auth->startCallback();

$vk = getjump\Vk\Core::getInstance()->apiVersion('5.65')->setToken($accessToken);
$posts = $vk->request('wall.get', [
	'domain' => "flatfeeder",
	'offset' => 13,
	'count'  => 50
])->getResponse();
$parseAttach = function($attachments){
	$result ="";
	foreach ($attachments as $attachment)
	{
		$attachment = (array) $attachment;
		if ($attachment['type'] !='link')
		{
			$attachment[$attachment['type']] =(array) $attachment[$attachment['type']];
			$result .= $attachment['type'].$attachment[$attachment['type']]['owner_id']."_".$attachment[$attachment['type']]['id'].",";
			
		}
	}
	return $result;
};
$result = null;
$count = 1;
foreach($posts as $post)
{
	
	
	$tmp = $vk->request('wall.post', [
		'owner_id' => '-34915724',
		'friends_only' => 0,
		'from_group'  => 0,
		'message' => $post->text,
		'attachments' => isset($post->attachments) ? $parseAttach($post->attachments) : "",
		'services' => "",
		'signed' => 0,
		'publish_date' => "",
		'lat' => '',
		'long' => '',
		'place_id' => '',
		'post_id' =>'',
		'guid' => '',
		'mark_as_ads' => '',
		'ads_promoted_stealth' => '',
	])->toJs();
	if (is_null($result))
	{
	 	$result = $tmp;
	}
	else
	{
		$result->append($tmp);
		$count++;
	}
	
	if($count >1)
	{
		$test = $result->execute()->response->getResponse();
		$result = null ;
		$count = 0;
	}
}
if($count <10)
{
	$test = $result->execute()->response->getResponse();
}

?>
