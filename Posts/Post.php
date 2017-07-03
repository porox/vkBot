<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 03.07.17
 * Time: 10:46
 */

namespace vkBot\Posts;


use vkBot\App;
use vkBot\Attachments\Attachments;

/**
 * Class Post
 *
 * @package vkBot
 */
class Post
{
	
	/**
	 * @var Attachments
	 */
	private $attachments;
	/**
	 * @var
	 */
	private $ownerId;
	/**
	 * @var
	 */
	private $id;
	/**
	 * @var
	 */
	private $text;
	
	private $date;
	
	private  $postType;
	private  $hash;
	
	
	/**
	 * Post constructor.
	 *
	 * @param \stdClass $postObj
	 */
	public function __construct(\stdClass $postObj)
	{
		if (isset($postObj->copy_history))
		{
			$postObj = $postObj->copy_history[0];
		}
		$this->id =$postObj->Id;
		$this->text = $postObj->text;
		$this->ownerId = $postObj->ownerId;
		$this->attachments = isset($postObj->attachments)? new Attachments($postObj->attachments) : [];
		$this->postType = $postObj->postType;
	}
	
	
	/**
	 * @return string
	 */
	private function getHash()
	{
		if (is_null($this->hash))
		{
			$hash = $this->text+ $this->attachments;
			$this->hash= md5($hash);
		}
		
		return $this->hash;
	}
	
	public function checkAlreadySend($groupId)
	{
		$db = App::get()->getPDOConnection();
		
		$obj =$db->prepare("SELECT * FORM sendedPosts WHERE hash LIKE '".$this->getHash()."'");
		return $obj->fetchAll() ? true : false;
	}
	public function sendPost()
	{
		$db = App::get()->getPDOConnection();
		
		$obj =$db->prepare('INSERT INTO sendedPosts SET  group_id= ? hash = ?',[1,$this->getHash()]);
		$obj->execute();
	}
}