<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 03.07.17
 * Time: 10:46
 */

namespace Posts;


use vkBot\App;
use Attachments\Attachments;

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
		$this->id =$postObj->id;
		$this->text = $postObj->text;
		$this->ownerId = $postObj->owner_id;
		$this->attachments = isset($postObj->attachments)? new Attachments($postObj->attachments) : "";
		$this->postType = $postObj->post_type;
		$this->date = $postObj->date;
	}
	
	
	/**
	 * @return string
	 */
	private function getHash()
	{
		if (is_null($this->hash))
		{
			$hash = $this->text." ".$this->attachments;
			$this->hash= md5($hash);
		}
		return $this->hash;
	}
	
	public function checkAlreadySend($groupId = 1)
	{
		$db = App::get()->getPDOConnection();
		
		$obj =$db->prepare("SELECT * FORM sendedPosts WHERE id_group = ".$groupId." hash = '".$this->getHash()."' FOR UPDATE");
		return empty($obj->fetchAll()) ? false : true;
	}
	public function sendPost($groupId = 1)
	{
		$db = App::get()->getPDOConnection();
		
		$obj = $db->prepare('INSERT INTO sendedPosts ( id_group, hash ) VALUES ('.$groupId.',"'.$this->getHash().'")');
		return $obj->execute();
	}
}