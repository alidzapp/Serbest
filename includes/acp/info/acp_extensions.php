<?php


class acp_extensions_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_extensions',
			'title'		=> 'ACP_EXTENSION_MANAGEMENT',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'main'		=> array('title' => 'ACP_EXTENSIONS', 'auth' => 'acl_a_extensions', 'cat' => array('ACP_EXTENSION_MANAGEMENT')),
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
