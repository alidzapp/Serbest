<?php

namespace src\db\migration\data\v310;

class srcrdindex extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['srcrd_index_text']);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('srcrd_index_text', '')),
		);
	}
}
