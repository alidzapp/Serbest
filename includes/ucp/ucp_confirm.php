<?php

/**
* @ignore
*/
if (!defined('IN_src'))
{
	exit;
}

class ucp_confirm
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $src_root_path, $config, $phpEx, $src_container;

		$captcha = $src_container->get('captcha.factory')->get_instance($config['captcha_plugin']);
		$captcha->init(request_var('type', 0));
		$captcha->execute();

		garbage_collection();
		exit_handler();
	}
}
