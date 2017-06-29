<?php

/**
 * Created by PhpStorm.
 * User: ydombrovsky
 * Date: 29.06.17
 * Time: 17:45
 */
namespace Cron;

use Cron\Scheduler;

require_once __DIR__.'/../vendor/autoload.php';


class testDemon extends Scheduler
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
		var_dump($data_item);
	}
	
}

(new testDemon(['debug'=>1]))->foreverLoop();