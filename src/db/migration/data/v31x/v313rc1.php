<?php


namespace src\db\migration\data\v31x;

class v313rc1 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v30x\release_3_0_13_rc1',
			'\src\db\migration\data\v31x\plupload_last_gc_dynamic',
			'\src\db\migration\data\v31x\profilefield_remove_underscore_from_alpha',
			'\src\db\migration\data\v31x\profilefield_yahoo_update_url',
			'\src\db\migration\data\v31x\update_custom_bbcodes_with_idn',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.3-RC1')),
		);
	}
}
