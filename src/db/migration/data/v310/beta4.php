<?php

namespace src\db\migration\data\v310;

class beta4 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\beta3',
			'\src\db\migration\data\v310\extensions_version_check_force_unstable',
			'\src\db\migration\data\v310\reset_missing_captcha_plugin',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-b4')),
		);
	}
}
