<?php

namespace src\db\migration\data\v310;

class profilefield_interests extends \src\db\migration\profilefield_base_migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\profilefield_types',
			'\src\db\migration\data\v310\profilefield_show_novalue',
		);
	}

	protected $profilefield_name = 'src_interests';

	protected $profilefield_database_type = array('MTEXT', '');

	protected $profilefield_data = array(
		'field_name'			=> 'src_interests',
		'field_type'			=> 'profilefields.type.text',
		'field_ident'			=> 'src_interests',
		'field_length'			=> '3|30',
		'field_minlen'			=> '2',
		'field_maxlen'			=> '500',
		'field_novalue'			=> '',
		'field_default_value'	=> '',
		'field_validation'		=> '.*',
		'field_required'		=> 0,
		'field_show_novalue'	=> 0,
		'field_show_on_reg'		=> 0,
		'field_show_on_pm'		=> 0,
		'field_show_on_vt'		=> 0,
		'field_show_profile'	=> 1,
		'field_hide'			=> 0,
		'field_no_view'			=> 0,
		'field_active'			=> 1,
	);

	protected $user_column_name = 'user_interests';
}
