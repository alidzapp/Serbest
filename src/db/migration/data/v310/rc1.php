<?php

namespace src\db\migration\data\v310;

class rc1 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\beta4',
			'\src\db\migration\data\v310\contact_admin_acp_module',
			'\src\db\migration\data\v310\contact_admin_form',
			'\src\db\migration\data\v310\passwords_convert_p2',
			'\src\db\migration\data\v310\profilefield_facebook',
			'\src\db\migration\data\v310\profilefield_googleplus',
			'\src\db\migration\data\v310\profilefield_skype',
			'\src\db\migration\data\v310\profilefield_twitter',
			'\src\db\migration\data\v310\profilefield_youtube',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-RC1')),
		);
	}
}
