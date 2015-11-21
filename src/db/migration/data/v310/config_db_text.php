<?php

namespace src\db\migration\data\v310;

class config_db_text extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'config_text');
	}

	static public function depends_on()
	{
		return array('\src\db\migration\data\v30x\release_3_0_11');
	}

	public function update_schema()
	{
		return array(
			'add_tables' => array(
				$this->table_prefix . 'config_text' => array(
					'COLUMNS' => array(
						'config_name'	=> array('VCHAR', ''),
						'config_value'	=> array('MTEXT', ''),
					),
					'PRIMARY_KEY' => 'config_name',
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'config_text',
			),
		);
	}
}
