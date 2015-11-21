<?php

namespace src\db\migration\data\v310;

class namespaces extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\dev',
		);
	}

	public function update_data()
	{
		return array(
			array('if', array(
				(preg_match('#^src_search_#', $this->config['search_type'])),
				array('config.update', array('search_type', str_replace('src_search_', '\\src\\search\\', $this->config['search_type']))),
			)),
		);
	}
}
