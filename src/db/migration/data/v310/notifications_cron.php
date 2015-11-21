<?php

namespace src\db\migration\data\v310;

class notifications_cron extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\notifications');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('read_notification_expire_days', 30)),
			array('config.add', array('read_notification_last_gc', 0)), // last run
			array('config.add', array('read_notification_gc', (60 * 60 * 24))), // seconds between run; 1 day
		);
	}
}
