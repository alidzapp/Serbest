<?php


namespace src\db\migration\data\v310;

class beta1 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\alpha3',
			'\src\db\migration\data\v310\passwords_p2',
			'\src\db\migration\data\v310\postgres_fulltext_drop',
			'\src\db\migration\data\v310\profilefield_change_load_settings',
			'\src\db\migration\data\v310\profilefield_location',
			'\src\db\migration\data\v310\soft_delete_mod_convert2',
			'\src\db\migration\data\v310\ucp_popuppm_module',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-b1')),
		);
	}
}
