<?php
require_once __DIR__.'/../autoloader.php';
use vkBot\App;
echo "Stop:".PHP_EOL;
foreach (App::get()->getCrons() as $script => $params)
{
	exec("ps axo pid,command | grep '" . $script . "' | grep -v grep | awk '{print $1}'", $pidsStop);
	if ($pidsStop)
	{
		$pidsStop = implode(' ', $pidsStop);
		exec('kill ' . $pidsStop);
		echo $script." - ".$pidsStop.PHP_EOL;
	}
}