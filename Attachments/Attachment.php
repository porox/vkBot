<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 03.07.17
 * Time: 11:52
 */

namespace vkBot\Attachments;


abstract class Attachment
{
	private $id;
	private $type;
	
	public function __construct(\stdClass $attachment)
	{
		$attachment = (array) $attachment;
		$this->type = $attachment['type'];
		$this->id = $attachment[$this->type]->id;
		$this->parseParams($attachment[$this->type]);
	}
	
	abstract function parseParams(\stdClass $attachment);
	
	public function forSend()
	{
		if (isset($this->ownerId))
		{
			return $this->type.$this->ownerId."_".$this->id;
		}
			
		return "";
	}
	
	public  function toString()
	{
		$res ='';
		$vars = get_object_vars($this);
		foreach ($vars as $key => $value){
			$res.= $key.":".$value.",";
		}
		return $res;
	}
	
	public function toArray(){
		$res= [];
		$vars = get_object_vars($this);
		foreach ($vars as $key => $value){
			
			$res[$key] = $value;
		}
	}
	
}