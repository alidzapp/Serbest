<?php

namespace src\db\migration\data\v310;

class allow_cdn extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['allow_cdn']);
	}

	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\jquery_update',
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('allow_cdn', (int) $this->config['load_jquery_cdn'])),
			array('config.remove', array('load_jquery_cdn')),
		);
	}
}
