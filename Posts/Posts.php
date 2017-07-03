<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 03.07.17
 * Time: 16:04
 */

namespace vkBot\Posts;
use lib\ArrayIterator;
use vkBot\App;

class Posts extends  ArrayIterator
{
	public function __construct(\stdClass $posts)
	{
		parent::__construct();
		
		foreach ($posts as $post)
		{
			$this->storage[] = new Post($post);
		}
	}
	
	public function checkSendedPosts($groupId)
	{
		foreach ($this->storage as $key => $post)
		{
			/**
			 * @var Post $post
			 */
			if ($post->checkAlreadySend($groupId))
			{
				unset ($this->storage[$key]);
			}
		}
	}
	
	public function sendPosts()
	{
		foreach ($this->storage as $key => $post)
		{
			
		}
	}
}