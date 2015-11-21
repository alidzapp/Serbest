<?php

namespace src\db\migration\data\v310;

class forgot_password extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['allow_password_reset']);
	}

	static public function depends_on()
	{
		return array('\src\db\migration\data\v30x\release_3_0_11');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('allow_password_reset', 1)),
		);
	}
}
