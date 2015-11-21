<?php

namespace src\db\migration\data\v310;

class beta3 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\beta2',
			'\src\db\migration\data\v310\auth_provider_oauth2',
			'\src\db\migration\data\v310\srcrd_contact_name',
			'\src\db\migration\data\v310\jquery_update2',
			'\src\db\migration\data\v310\live_searches_config',
			'\src\db\migration\data\v310\prune_shadow_topics',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-b3')),
		);
	}
}
