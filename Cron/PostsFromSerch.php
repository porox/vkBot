<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 04.07.17
 * Time: 13:18
 */

namespace Cron;

require_once __DIR__.'/../autoloader.php';

use Posts\Post;
use vkBot\App;
use Posts\Posts;

class PostsFromSerch  extends Scheduler
{
	private $vkInstance;
	
	private  $groupId;
	
	public function __construct(array $options)
	{
		parent::__construct($options);
		$this->vkInstance = App::get()->getVkInstanse();
		$this->groupId = $_SERVER['argv'][1];
	}
	
	protected function provider()
	{
		$posts = $this->vkInstance->request('newsfeed.search', [
			'q' => 'репост лайк конкурс like розыгрыш приз',
			'extended'=> '',
			'count' => 15,
		])->getResponse();
		
		$posts = new Posts($posts);
		App::get()->getPDOConnection()->beginTransaction();
		try
		{
			$posts->checkSendedPosts($this->groupId);
			
			foreach ($posts as $post)
			{
				yield $post;
			}
			
			App::get()->getPDOConnection()->commit();
		}
		catch (\Exception $e)
		{
			App::get()->getPDOConnection()->rollBack();
		}
	}
	
	/**
	 * @param Post $item
	 */
	protected function handler(&$item)
	{
		var_dump($item);
		$messsage = $item->getMessageForSend($this->groupId);
		$messsage = json_decode($messsage);
		var_dump($messsage);
		//todo need save post in DB ;
		//App::get()->getPDOConnection()->prepare("INSERT INTO ")
		
		$item->markAsProcessed($this->groupId);
	}
	
}
(new PostsFromSerch(['debug'=>0,'loop_delay'=>10000]))->foreverLoop();