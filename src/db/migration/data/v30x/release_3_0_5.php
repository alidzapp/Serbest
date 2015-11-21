<?php

namespace src\db\migration\data\v30x;

class release_3_0_5 extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return src_version_compare($this->config['version'], '3.0.5', '>=');
	}

	static public function depends_on()
	{
		return array('\src\db\migration\data\v30x\release_3_0_5_rc1part2');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.0.5')),
		);
	}
}
