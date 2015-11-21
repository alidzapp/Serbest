<?php
namespace src\db\migration\data\v310;

class alpha2 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\alpha1',
			'\src\db\migration\data\v310\notifications_cron_p2',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-a2')),
		);
	}
}
