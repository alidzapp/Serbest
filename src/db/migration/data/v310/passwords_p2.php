<?php
namespace src\db\migration\data\v310;

class passwords_p2 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\passwords');
	}

	public function update_schema()
	{
		return array(
			'change_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_newpasswd'		=> array('VCHAR:255', ''),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'change_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_newpasswd'		=> array('VCHAR:40', ''),
				),
			),
		);
	}
}
