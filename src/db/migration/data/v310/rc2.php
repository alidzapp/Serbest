<?php

namespace src\db\migration\data\v310;

class rc2 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\rc1',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-RC2')),
		);
	}
}
