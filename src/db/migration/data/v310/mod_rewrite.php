<?php
namespace src\db\migration\data\v310;

class mod_rewrite extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\dev',
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('enable_mod_rewrite', '0')),
		);
	}
}
