<?php


class acp_srcrd_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_srcrd',
			'title'		=> 'ACP_srcRD_MANAGEMENT',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'		=> array('title' => 'ACP_srcRD_SETTINGS', 'auth' => 'acl_a_srcrd', 'cat' => array('ACP_srcRD_CONFIGURATION')),
				'features'		=> array('title' => 'ACP_srcRD_FEATURES', 'auth' => 'acl_a_srcrd', 'cat' => array('ACP_srcRD_CONFIGURATION')),
				'avatar'		=> array('title' => 'ACP_AVATAR_SETTINGS', 'auth' => 'acl_a_srcrd', 'cat' => array('ACP_srcRD_CONFIGURATION')),
				'message'		=> array('title' => 'ACP_MESSAGE_SETTINGS', 'auth' => 'acl_a_srcrd', 'cat' => array('ACP_srcRD_CONFIGURATION', 'ACP_MESSAGES')),
				'post'			=> array('title' => 'ACP_POST_SETTINGS', 'auth' => 'acl_a_srcrd', 'cat' => array('ACP_srcRD_CONFIGURATION', 'ACP_MESSAGES')),
				'signature'		=> array('title' => 'ACP_SIGNATURE_SETTINGS', 'auth' => 'acl_a_srcrd', 'cat' => array('ACP_srcRD_CONFIGURATION')),
				'feed'			=> array('title' => 'ACP_FEED_SETTINGS', 'auth' => 'acl_a_srcrd', 'cat' => array('ACP_srcRD_CONFIGURATION')),
				'registration'	=> array('title' => 'ACP_REGISTER_SETTINGS', 'auth' => 'acl_a_srcrd', 'cat' => array('ACP_srcRD_CONFIGURATION')),

				'auth'		=> array('title' => 'ACP_AUTH_SETTINGS', 'auth' => 'acl_a_server', 'cat' => array('ACP_CLIENT_COMMUNICATION')),
				'email'		=> array('title' => 'ACP_EMAIL_SETTINGS', 'auth' => 'acl_a_server', 'cat' => array('ACP_CLIENT_COMMUNICATION')),

				'cookie'	=> array('title' => 'ACP_COOKIE_SETTINGS', 'auth' => 'acl_a_server', 'cat' => array('ACP_SERVER_CONFIGURATION')),
				'server'	=> array('title' => 'ACP_SERVER_SETTINGS', 'auth' => 'acl_a_server', 'cat' => array('ACP_SERVER_CONFIGURATION')),
				'security'	=> array('title' => 'ACP_SECURITY_SETTINGS', 'auth' => 'acl_a_server', 'cat' => array('ACP_SERVER_CONFIGURATION')),
				'load'		=> array('title' => 'ACP_LOAD_SETTINGS', 'auth' => 'acl_a_server', 'cat' => array('ACP_SERVER_CONFIGURATION')),
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
