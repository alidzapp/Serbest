<?php
namespace src\db\migration\data\v310;

class profilefield_googleplus extends \src\db\migration\profilefield_base_migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\profilefield_contact_field',
			'\src\db\migration\data\v310\profilefield_show_novalue',
			'\src\db\migration\data\v310\profilefield_types',
		);
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'create_custom_field'))),
		);
	}

	protected $profilefield_name = 'src_googleplus';

	protected $profilefield_database_type = array('VCHAR', '');

	protected $profilefield_data = array(
		'field_name'			=> 'src_googleplus',
		'field_type'			=> 'profilefields.type.googleplus',
		'field_ident'			=> 'src_googleplus',
		'field_length'			=> '20',
		'field_minlen'			=> '3',
		'field_maxlen'			=> '255',
		'field_novalue'			=> '',
		'field_default_value'	=> '',
		'field_validation'		=> '[\w]+',
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
		'field_contact_desc'	=> 'VIEW_GOOGLEPLUS_PROFILE',
		'field_contact_url'		=> 'http://plus.google.com/%s',
	);
}
