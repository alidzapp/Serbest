<?php

namespace src\db\migration\data\v31x;

class v312rc1 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v31x\v311',
			'\src\db\migration\data\v31x\m_softdelete_global',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.2-RC1')),
		);
	}
}
