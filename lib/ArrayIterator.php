<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 03.07.17
 * Time: 14:16
 */

namespace lib;


class ArrayIterator  implements  \Iterator
{
	/**
	 * @var array
	 */
	protected $storage;
	
	/**
	 * @var int
	 */
	protected $index ;
	
	public function __construct()
	{
		$this->index = 0;
	}
	
	/**
	 *
	 */
	public function current()
	{
		$this->storage[$this->index];
	}
	
	/**
	 *
	 */
	public function next()
	{
		$this->index ++;
	}
	
	/**
	 * @return int
	 */
	public function key()
	{
		return $this->index;
	}
	
	/**
	 * @return bool
	 */
	public function valid()
	{
		return isset($this->storage[$this->index]);
	}
	
	/**
	 *
	 */
	public function rewind()
	{
		$this->index = 0;
	}
	
	
}