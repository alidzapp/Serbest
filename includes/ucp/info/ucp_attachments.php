<?php


class ucp_attachments_info
{
	function module()
	{
		return array(
			'filename'	=> 'ucp_attachments',
			'title'		=> 'UCP_ATTACHMENTS',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'attachments'	=> array('title' => 'UCP_MAIN_ATTACHMENTS', 'auth' => 'acl_u_attach', 'cat' => array('UCP_MAIN')),
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
