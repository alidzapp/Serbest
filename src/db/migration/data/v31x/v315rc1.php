<?php

namespace src\db\migration\data\v31x;

class v315rc1 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v31x\v314',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.5-RC1')),
		);
	}
}
