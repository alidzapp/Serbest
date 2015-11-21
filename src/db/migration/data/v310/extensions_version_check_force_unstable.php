<?php
namespace src\db\migration\data\v310;

class extensions_version_check_force_unstable extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('extension_force_unstable', false)),
		);
	}
}
