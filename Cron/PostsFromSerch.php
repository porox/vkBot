<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 04.07.17
 * Time: 13:18
 */

namespace Cron;

require_once __DIR__ . '/../autoloader.php';

use Posts\Post;
use vkBot\App;
use Posts\Posts;

/**
 * Class PostsFromSerch
 *
 * @package Cron
 */
class PostsFromSerch extends Scheduler
{
	/**
	 * @var \getjump\Vk\Core|null
	 */
	private $vkInstance;
	
	/**
	 * @var
	 */
	private $groupId;
	
	/**
	 * PostsFromSerch constructor.
	 *
	 * @param array $options
	 */
	public function __construct(array $options)
	{
		parent::__construct($options);
		$this->vkInstance = App::get()->getVkInstanse();
		$this->groupId    = $_SERVER['argv'][1];
	}
	
	/**
	 * @return \Generator
	 */
	protected function provider()
	{
		//todo fix q hardcode
		$posts = $this->vkInstance->request('newsfeed.search', [
			'q'        => 'репост лайк конкурс like розыгрыш приз',
			'extended' => '',
			'count'    => 15,
		])->getResponse();
		
		$posts = new Posts($posts);
		App::get()->getPDOConnection()->beginTransaction();
		try
		{
			foreach ($posts as $post)
			{
				yield $post;
			}
			
			App::get()->getPDOConnection()->commit();
		} catch (\Exception $e)
		{
			App::get()->getPDOConnection()->rollBack();
		}
	}
	
	/**
	 * @param Post $item
	 */
	protected function handler(&$item)
	{
		if (!$item->checkAlreadySend($this->groupId))
		{
			//todo pocessed post text
			$messsage = $item->getMessageForSend($this->groupId);
			$messsage = json_encode($messsage);
			$query    = App::get()->getPDOConnection()->prepare("INSERT INTO postsNeedSend ( group_id, post_data) VALUES ( :groupId,:postData) ");
			$query->execute([
				'groupId'  => $this->groupId,
				'postData' => $messsage
			]);
			$item->markAsProcessed($this->groupId);
		}
		unset($item);
	}
	
}

//start once in 30 min
(new PostsFromSerch(['debug'      => 0,
					 'loop_delay' => 30 * 60 //39 min
]))->foreverLoop();