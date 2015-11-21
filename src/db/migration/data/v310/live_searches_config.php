<?php

namespace src\db\migration\data\v310;

class live_searches_config extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['allow_live_searches']);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('allow_live_searches', '1')),
		);
	}
}
