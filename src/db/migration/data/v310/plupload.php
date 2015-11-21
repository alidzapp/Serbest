<?php
namespace src\db\migration\data\v310;

class plupload extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['plupload_last_gc']) &&
			isset($this->config['plupload_salt']);
	}

	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('plupload_last_gc', 0)),
			array('config.add', array('plupload_salt', unique_id())),
		);
	}
}
