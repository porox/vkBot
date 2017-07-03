<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 03.07.17
 * Time: 13:48
 */

namespace vkBot\Attachments\Types;

use vkBot\Attachments\Attachment;

class Photo extends Attachment
{
	private  $ownerId;
	private  $albumId;
	private  $userId;
	private  $text;
	private  $date;
	private  $sizes;
	
	function parseParams(\stdClass $attachment)
	{
		$this->ownerId = $attachment->ownerId;
		$this->albumId = $attachment->albumId;
		$this->userId = $attachment->userId;
		$this->text = $attachment->text;
		$this->date = $attachment->date;
		$this->sizes = $attachment->sizes;
	}
	
}