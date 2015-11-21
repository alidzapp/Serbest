<?php

namespace src\db\migration\data\v31x;

class v311 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\gold',
			'\src\db\migration\data\v31x\style_update',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.1')),
		);
	}
}
