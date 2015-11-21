<?php

namespace src\db\migration\data\v310;

class profilefield_change_load_settings extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\profilefield_aol_cleanup',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('load_cpf_memberlist', '1')),
			array('config.update', array('load_cpf_pm', '1')),
			array('config.update', array('load_cpf_viewprofile', '1')),
			array('config.update', array('load_cpf_viewtopic', '1')),
		);
	}
}
