<?php


/**
* @ignore
*/
if (!defined('IN_src'))
{
	exit;
}

class acp_update
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $user, $template, $request;
		global $src_root_path, $phpEx, $src_container;

		$user->add_lang('install');

		$this->tpl_name = 'acp_update';
		$this->page_title = 'ACP_VERSION_CHECK';

		$version_helper = $src_container->get('version_helper');
		try
		{
			$recheck = $request->variable('versioncheck_force', false);
			$updates_available = $version_helper->get_suggested_updates($recheck);
		}
		catch (\RuntimeException $e)
		{
			$template->assign_var('S_VERSIONCHECK_FAIL', true);

			$updates_available = array();
		}

		foreach ($updates_available as $branch => $version_data)
		{
			$template->assign_block_vars('updates_available', $version_data);
		}

		$update_link = append_sid($src_root_path . 'install/index.' . $phpEx, 'mode=update');

		$template->assign_vars(array(
			'S_UP_TO_DATE'			=> empty($updates_available),
			'U_ACTION'				=> $this->u_action,
			'U_VERSIONCHECK_FORCE'	=> append_sid($this->u_action . '&amp;versioncheck_force=1'),

			'CURRENT_VERSION'		=> $config['version'],

			'UPDATE_INSTRUCTIONS'	=> sprintf($user->lang['UPDATE_INSTRUCTIONS'], $update_link),
		));
	}
}
