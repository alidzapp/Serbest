<?php
namespace src\db\migration\data\v310;

class topic_sort_username extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return array(
			'change_columns' => array(
				$this->table_prefix . 'topics'	=> array(
					'topic_first_poster_name' => array('VCHAR_UNI:255', '', 'true_sort'),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'change_columns' => array(
				$this->table_prefix . 'topics'	=> array(
					'topic_first_poster_name' => array('VCHAR_UNI:255', ''),
				),
			),
		);
	}
}
