<?php

class ucp_notifications_info
{
	function module()
	{
		return array(
			'filename'	=> 'ucp_notifications',
			'title'		=> 'UCP_NOTIFICATION_OPTIONS',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'notification_options'		=> array('title' => 'UCP_NOTIFICATION_OPTIONS', 'auth' => '', 'cat' => array('UCP_PREFS')),
				'notification_list'			=> array('title' => 'UCP_NOTIFICATION_LIST', 'auth' => '', 'cat' => array('UCP_MAIN')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}
