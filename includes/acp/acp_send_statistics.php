<?php


/**
* @ignore
*/
if (!defined('IN_src'))
{
	exit;
}

class acp_send_statistics
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $template, $src_admin_path, $src_root_path, $phpEx;

		include($src_root_path . 'includes/questionnaire/questionnaire.' . $phpEx);

		$collect_url = "https://www.src.com/stats/receive_stats.php";

		$this->tpl_name = 'acp_send_statistics';
		$this->page_title = 'ACP_SEND_STATISTICS';

		// generate a unique id if necessary
		if (!isset($config['questionnaire_unique_id']))
		{
			$install_id = unique_id();
			set_config('questionnaire_unique_id', $install_id);
		}
		else
		{
			$install_id = $config['questionnaire_unique_id'];
		}

		$collector = new src_questionnaire_data_collector($install_id);

		// Add data provider
		$collector->add_data_provider(new src_questionnaire_php_data_provider());
		$collector->add_data_provider(new src_questionnaire_system_data_provider());
		$collector->add_data_provider(new src_questionnaire_src_data_provider($config));

		$template->assign_vars(array(
			'U_COLLECT_STATS'	=> $collect_url,
			'RAW_DATA'			=> $collector->get_data_for_form(),
			'U_ACP_MAIN'		=> append_sid("{$src_admin_path}index.$phpEx"),
		));

		$raw = $collector->get_data_raw();

		foreach ($raw as $provider => $data)
		{
			if ($provider == 'install_id')
			{
				$data = array($provider => $data);
			}

			$template->assign_block_vars('providers', array(
				'NAME'	=> htmlspecialchars($provider),
			));

			foreach ($data as $key => $value)
			{
				if (is_array($value))
				{
					$value = utf8_wordwrap(serialize($value), 75, "\n", true);
				}

				$template->assign_block_vars('providers.values', array(
					'KEY'	=> utf8_htmlspecialchars($key),
					'VALUE'	=> utf8_htmlspecialchars($value),
				));
			}
		}
	}
}
