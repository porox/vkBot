<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 03.07.17
 * Time: 13:42
 */

namespace Attachments;
use \Attachments\Types\Bace;

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
			$path = __DIR__."/Types/".$attachment->type;
			return new $path($attachment);
		}
		return new Bace($attachment);
	}
}