<?php
/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 29.06.17
 * Time: 18:06
 */

namespace Cron;

use \Cron\Scheduler;

require_once __DIR__.'/../autoloader.php';

class Test extends \Cron\Scheduler
{
	protected function provider()
	{
		$max = rand(10,100);
		
		for($i = 0; $i <$max;$i++)
		{
			yield $i;
		}
	}
	
	protected function handler(&$data_item)
	{
		echo $data_item .PHP_EOL;
	}
}

(new Test(['debug'=>0]))->foreverLoop();