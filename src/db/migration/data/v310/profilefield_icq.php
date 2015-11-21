<?php

namespace src\db\migration\data\v310;

class profilefield_icq extends \src\db\migration\profilefield_base_migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\profilefield_contact_field',
		);
	}

	protected $profilefield_name = 'src_icq';

	protected $profilefield_database_type = array('VCHAR', '');

	protected $profilefield_data = array(
		'field_name'			=> 'src_icq',
		'field_type'			=> 'profilefields.type.string',
		'field_ident'			=> 'src_icq',
		'field_length'			=> '20',
		'field_minlen'			=> '3',
		'field_maxlen'			=> '15',
		'field_novalue'			=> '',
		'field_default_value'	=> '',
		'field_validation'		=> '[0-9]+',
		'field_required'		=> 0,
		'field_show_novalue'	=> 0,
		'field_show_on_reg'		=> 0,
		'field_show_on_pm'		=> 1,
		'field_show_on_vt'		=> 1,
		'field_show_profile'	=> 1,
		'field_hide'			=> 0,
		'field_no_view'			=> 0,
		'field_active'			=> 1,
		'field_is_contact'		=> 1,
		'field_contact_desc'	=> 'SEND_ICQ_MESSAGE',
		'field_contact_url'		=> 'https://www.icq.com/people/%s/',
	);

	protected $user_column_name = 'user_icq';
}
