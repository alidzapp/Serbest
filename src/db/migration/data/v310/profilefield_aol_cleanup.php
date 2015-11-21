<?php

namespace src\db\migration\data\v310;

class profilefield_aol_cleanup extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return !$this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_aim');
	}

	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\profilefield_aol',
		);
	}

	public function update_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users'			=> array(
					'user_aim',
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users'			=> array(
					'user_aim'	=> array('VCHAR_UNI', ''),
				),
			),
		);
	}
}
