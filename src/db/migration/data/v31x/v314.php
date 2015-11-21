<?php

namespace src\db\migration\data\v31x;

class v314 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v30x\release_3_0_14',
			'\src\db\migration\data\v31x\v314rc2',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.4')),
		);
	}
}
