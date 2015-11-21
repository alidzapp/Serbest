<?php


define('IN_src', true);
define('IN_CRON', true);
$src_root_path = (defined('src_ROOT_PATH')) ? src_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($src_root_path . 'common.' . $phpEx);

// Do not update users last page entry
$user->session_begin(false);
$auth->acl($user->data);

function output_image()
{
	// Output transparent gif
	header('Cache-Control: no-cache');
	header('Content-type: image/gif');
	header('Content-length: 43');

	echo base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');

	// Flush here to prevent browser from showing the page as loading while
	// running cron.
	flush();
}

// Thanks to various fatal errors and lack of try/finally, it is quite easy to leave
// the cron lock locked, especially when working on cron-related code.
//
// Attempt to alleviate the problem by doing setup outside of the lock as much as possible.

$cron_type = request_var('cron_type', '');

// Comment this line out for debugging so the page does not return an image.
output_image();

$cron_lock = $src_container->get('cron.lock_db');
if ($cron_lock->acquire())
{
	$cron = $src_container->get('cron.manager');

	$task = $cron->find_task($cron_type);
	if ($task)
	{
		if ($task->is_parametrized())
		{
			$task->parse_parameters($request);
		}
		if ($task->is_ready())
		{
			$task->run();
		}
	}
	$cron_lock->release();
}

garbage_collection();
