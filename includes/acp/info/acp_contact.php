<?php


/**
* @package module_install
*/
class acp_contact_info
{
	public function module()
	{
		return array(
			'filename'	=> 'acp_contact',
			'title'		=> 'ACP_CONTACT',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'contact'	=> array('title' => 'ACP_CONTACT_SETTINGS', 'auth' => 'acl_a_srcrd', 'cat' => array('ACP_srcRD_CONFIGURATION')),
			),
		);
	}
}
