<?php


namespace src\db\migration\data\v31x;

class v313rc2 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v30x\release_3_0_13_pl1',
			'\src\db\migration\data\v31x\v313rc1',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.3-RC2')),
		);
	}
}
