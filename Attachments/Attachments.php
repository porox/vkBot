<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 03.07.17
 * Time: 12:36
 */

namespace Attachments;
use Attachments\AttachmentFactory;
use \lib\ArrayIterator;

/**
 * Class Attachments
 *
 * @package vkBot\Attachments
 */
class Attachments extends ArrayIterator
{
	/**
	 * Attachments constructor.
	 *
	 * @param \stdClass $attachments
	 */
	public function __construct(array $attachments)
	{
		parent::__construct();
		
		foreach ($attachments as $attachment)
		{
			$this->storage[] = AttachmentFactory::getAttachmentByType($attachment);
		}
	}
	
	public function  __toString()
	{
		$res = [];
		foreach ($this->storage as $attach)
		{
			/**
			 * @var  Attachment $attach
			 */
			$res[] = $attach->toString();
		}
		return implode(",",$res);
	}
	
	public function  getAttachmentsForSend()
	{
		$res = [];
		foreach ($this->storage as $attach)
		{
			/**
			 * @var  Attachment $attach
			 */
			$res[] = $attach->forSend();
		}
		
		return implode(",",$res);
	}
	
}