<?php

namespace src\db\migration\data\v310;

class srcrd_contact_name extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['srcrd_contact_name']);
	}

	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\beta2');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('srcrd_contact_name', '')),
		);
	}
}
