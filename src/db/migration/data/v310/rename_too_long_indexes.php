<?php

namespace src\db\migration\data\v310;

class rename_too_long_indexes extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v30x\release_3_0_0');
	}

	public function update_schema()
	{
		return array(
			'drop_keys' => array(
				$this->table_prefix . 'search_wordmatch' => array(
					'unq_mtch',
				),
			),
			'add_unique_index' => array(
				$this->table_prefix . 'search_wordmatch' => array(
					'un_mtch'	=> array('word_id', 'post_id', 'title_match'),
				),
			),
		);
	}
}
