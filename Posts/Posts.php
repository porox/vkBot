<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 03.07.17
 * Time: 16:04
 */

namespace Posts;

use lib\ArrayIterator;
use vkBot\App;

class Posts extends ArrayIterator
{
	public function __construct(array $posts)
	{
		parent::__construct();
		
		foreach ($posts as $post)
		{
			$this->storage[$this->index] = new Post($post);
			$this->index                 = ++$this->index;
		}
	}
}