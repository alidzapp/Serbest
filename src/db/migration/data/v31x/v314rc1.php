<?php

namespace src\db\migration\data\v31x;

class v314rc1 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v31x\v313',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.4-RC1')),
		);
	}
}
