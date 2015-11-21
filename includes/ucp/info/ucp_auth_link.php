<?php


class ucp_auth_link_info
{
	function module()
	{
		return array(
			'filename'	=> 'ucp_auth_link',
			'title'		=> 'UCP_AUTH_LINK',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'auth_link'	=> array('title' => 'UCP_AUTH_LINK_MANAGE', 'auth' => 'authmethod_oauth', 'cat' => array('UCP_PROFILE')),
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
