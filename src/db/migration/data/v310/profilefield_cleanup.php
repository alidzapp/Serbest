<?php

namespace src\db\migration\data\v310;

class profilefield_cleanup extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return !$this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_occ') &&
			!$this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_interests');
	}

	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\profilefield_interests',
			'\src\db\migration\data\v310\profilefield_occupation',
		);
	}

	public function update_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users'			=> array(
					'user_occ',
					'user_interests',
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users'			=> array(
					'user_occ'			=> array('MTEXT', ''),
					'user_interests'	=> array('MTEXT', ''),
				),
			),
		);
	}
}
