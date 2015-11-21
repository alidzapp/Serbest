<?php
namespace src\db\migration\data\v310;

class gold extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\rc6',
			'\src\db\migration\data\v310\bot_update',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0')),
		);
	}
}
