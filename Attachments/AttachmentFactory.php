<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 03.07.17
 * Time: 13:42
 */

namespace vkBot\Attachments;


/**
 * Class AttachmentFactory
 *
 * @package vkBot\Attachments
 */
class AttachmentFactory
{
	
	/**
	 * @param \stdClass $attachment
	 *
	 * @return Attachment
	 */
	static function getAttachmentByType(\stdClass $attachment)
	{
		if (class_exists(__DIR__."/Types/".$attachment->type) && class_implements('vkBot\Attachments\Attachment'))
		{
			return new (__DIR__."/Types/".$attachment->type)($attachment);
		}
		return new \vkBot\Attachments\Types\Bace($attachment);
	}
}