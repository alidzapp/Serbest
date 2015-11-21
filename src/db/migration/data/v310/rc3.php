<?php

namespace src\db\migration\data\v310;

class rc3 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\rc2',
			'\src\db\migration\data\v310\captcha_plugins',
			'\src\db\migration\data\v310\rename_too_long_indexes',
			'\src\db\migration\data\v310\search_type',
			'\src\db\migration\data\v310\topic_sort_username',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-RC3')),
		);
	}
}
