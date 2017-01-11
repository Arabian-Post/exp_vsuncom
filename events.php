<?php
namespace KVSun;

use \shgysk8zer0\Core as Core;
use \shgysk8zer0\DOM as DOM;

new Core\Listener('error', function($severity, $message, $file, $line)
{
	file_put_contents(
		'errors.log',
		"Error: '{$message}' in {$file}:{$line}" . PHP_EOL,
		FILE_APPEND |  LOCK_EX
	);
});

new Core\Listener('exception', function($e)
{
	file_put_contents('exceptions.log', $e . PHP_EOL, FILE_APPEND | LOCK_EX);
});

if (check_role('admin') or DEBUG) {
	$timer = new Core\Timer();
	new Core\Listener('load', function() use ($timer)
	{
		Core\Console::info("Loaded in $timer seconds.");
		Core\Console::getInstance()->sendLogHeader();
	});
	new Core\Listener('error', '\shgysk8zer0\Core\Console::error');
	new Core\Listener('exception', '\shgysk8zer0\Core\Console::error');
	unset($timer);
}