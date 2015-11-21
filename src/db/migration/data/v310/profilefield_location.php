<?php

namespace src\db\migration\data\v310;

class profilefield_location extends \src\db\migration\profilefield_base_migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\profilefield_types',
			'\src\db\migration\data\v310\profilefield_on_memberlist',
		);
	}

	protected $profilefield_name = 'src_location';

	protected $profilefield_database_type = array('VCHAR', '');

	protected $profilefield_data = array(
		'field_name'			=> 'src_location',
		'field_type'			=> 'profilefields.type.string',
		'field_ident'			=> 'src_location',
		'field_length'			=> '20',
		'field_minlen'			=> '2',
		'field_maxlen'			=> '100',
		'field_novalue'			=> '',
		'field_default_value'	=> '',
		'field_validation'		=> '.*',
		'field_required'		=> 0,
		'field_show_novalue'	=> 0,
		'field_show_on_reg'		=> 0,
		'field_show_on_pm'		=> 1,
		'field_show_on_vt'		=> 1,
		'field_show_profile'	=> 1,
		'field_hide'			=> 0,
		'field_no_view'			=> 0,
		'field_active'			=> 1,
	);

	protected $user_column_name = 'user_from';
}
