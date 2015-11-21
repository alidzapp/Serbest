<?php

namespace src\captcha\plugins;

class nogd extends captcha_abstract
{
	public function is_available()
	{
		return true;
	}

	public function get_name()
	{
		return 'CAPTCHA_NO_GD';
	}

	/**
	* @return string the name of the class used to generate the captcha
	*/
	function get_generator_class()
	{
		return '\\src\\captcha\\non_gd';
	}

	function acp_page($id, &$module)
	{
		global $user;

		trigger_error($user->lang['CAPTCHA_NO_OPTIONS'] . adm_back_link($module->u_action));
	}
}
