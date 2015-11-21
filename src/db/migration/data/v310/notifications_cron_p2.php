<?php
namespace src\db\migration\data\v310;

class notifications_cron_p2 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\notifications_cron');
	}

	public function update_data()
	{
		return array(
			// Make read_notification_last_gc dynamic.
			array('config.remove', array('read_notification_last_gc')),
			array('config.add', array('read_notification_last_gc', 0, 1)),
		);
	}
}
