<?php

namespace src\db\migration\data\v310;

class search_type extends \src\db\migration\migration
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
				(is_file($this->src_root_path . 'src/search/' . $this->config['search_type'] . $this->php_ext)),
				array('config.update', array('search_type', '\\src\\search\\' . $this->config['search_type'])),
			)),
		);
	}
}
