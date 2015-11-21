<?php


namespace src\db\migration\data\v310;

class beta2 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\beta1',
			'\src\db\migration\data\v310\acp_prune_users_module',
			'\src\db\migration\data\v310\profilefield_location_cleanup',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-b2')),
		);
	}
}
