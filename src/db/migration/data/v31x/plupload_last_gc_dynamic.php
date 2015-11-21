<?php

namespace src\db\migration\data\v31x;

class plupload_last_gc_dynamic extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v31x\v312');
	}

	public function update_data()
	{
		return array(
			// Make plupload_last_gc dynamic.
			array('config.remove', array('plupload_last_gc')),
			array('config.add', array('plupload_last_gc', 0, 1)),
		);
	}
}
