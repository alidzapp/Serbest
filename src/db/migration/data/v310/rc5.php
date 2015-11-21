<?php

namespace src\db\migration\data\v310;

class rc5 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\rc4',
			'\src\db\migration\data\v310\profilefield_field_validation_length',
			'\src\db\migration\data\v310\remove_acp_styles_cache',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-RC5')),
		);
	}
}
