<?php

namespace src\db\migration\data\v310;

class contact_admin_acp_module extends \src\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'ACP_srcRD_CONFIGURATION',
				array(
					'module_basename'	=> 'acp_contact',
					'modes'				=> array('contact'),
				),
			)),
		);
	}
}
