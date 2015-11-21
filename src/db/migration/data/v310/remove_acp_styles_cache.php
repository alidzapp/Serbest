<?php

namespace src\db\migration\data\v310;

class remove_acp_styles_cache extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		$sql = 'SELECT module_id
			FROM ' . MODULES_TABLE . "
			WHERE module_class = 'acp'
				AND module_langname = 'ACP_STYLES_CACHE'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return !$module_id;
	}

	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\rc4');
	}

	public function update_data()
	{
		return array(
			array('module.remove', array(
				'acp',
				'ACP_STYLE_MANAGEMENT',
				array(
					'module_basename'   => 'acp_styles',
					'module_langname'   => 'ACP_STYLES_CACHE',
					'module_mode'       => 'cache',
					'module_auth'       => 'acl_a_styles',
				),
			)),
		);
	}
}
