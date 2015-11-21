<?php

namespace src\db\migration\data\v310;

class prune_shadow_topics extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return array(
			'add_columns'		=> array(
				$this->table_prefix . 'forums'		=> array(
					'enable_shadow_prune'	=> array('BOOL', 0),
					'prune_shadow_days'	=> array('UINT', 7),
					'prune_shadow_freq'	=> array('UINT', 1),
					'prune_shadow_next'	=> array('INT:11', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'		=> array(
				$this->table_prefix . 'forums'		=> array(
					'enable_shadow_prune',
					'prune_shadow_days',
					'prune_shadow_freq',
					'prune_shadow_next',
				),
			),
		);
	}
}