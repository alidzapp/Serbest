<?php

namespace src\db\migration\data\v310;

class acp_style_components_module extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		$sql = 'SELECT module_id
			FROM ' . MODULES_TABLE . "
			WHERE module_class = 'acp'
				AND module_langname = 'ACP_STYLE_COMPONENTS'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id == false;
	}

	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('module.remove', array(
				'acp',
				false,
				'ACP_STYLE_COMPONENTS',
			)),
		);
	}
}
