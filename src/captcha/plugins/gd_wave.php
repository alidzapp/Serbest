<?php
namespace src\captcha\plugins;

class gd_wave extends captcha_abstract
{
	public function is_available()
	{
		return @extension_loaded('gd');
	}

	public function get_name()
	{
		return 'CAPTCHA_GD_3D';
	}

	/**
	* @return string the name of the class used to generate the captcha
	*/
	function get_generator_class()
	{
		return '\\src\\captcha\\gd_wave';
	}

	function acp_page($id, &$module)
	{
		global $config, $db, $template, $user;

		trigger_error($user->lang['CAPTCHA_NO_OPTIONS'] . adm_back_link($module->u_action));
	}
}
