<?php

namespace src\db\migration\data\v310;

class profilefield_yahoo_cleanup extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return !$this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_yim');
	}

	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\profilefield_yahoo',
		);
	}

	public function update_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users'			=> array(
					'user_yim',
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users'			=> array(
					'user_yim'	=> array('VCHAR_UNI', ''),
				),
			),
		);
	}
}
