<?php

namespace src\db\migration\data\v31x;

class m_softdelete_global extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v31x\v311');
	}

	public function update_data()
	{
		return array(
			// Make m_softdelete global. The add method will take care of updating
			// it if it already exists.
			array('permission.add', array('m_softdelete', true)),
		);
	}
}
