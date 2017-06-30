<?php
require_once __DIR__.'/../autoloader.php';
use vkBot\App;
echo "Run:".PHP_EOL;
foreach (App::get()->getCrons() as $script)
{
	$path = realpath (__DIR__."/../".$script);
	exec('/usr/bin/php ' . $path . ' > /dev/null &');
	
	exec("ps axo pid,command | grep '" . $script . "' | grep -v grep | awk '{print $1}'", $pidsStarting);
	
	echo $script." - ".implode(' ', $pidsStarting).PHP_EOL;
}