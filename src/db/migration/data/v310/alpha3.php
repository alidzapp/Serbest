<?php


namespace src\db\migration\data\v310;

class alpha3 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\alpha2',
			'\src\db\migration\data\v310\avatar_types',
			'\src\db\migration\data\v310\passwords',
			'\src\db\migration\data\v310\profilefield_types',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-a3')),
		);
	}
}
