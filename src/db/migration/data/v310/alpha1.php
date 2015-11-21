<?php

namespace src\db\migration\data\v310;

class alpha1 extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v30x\local_url_bbcode',
			'\src\db\migration\data\v30x\release_3_0_12',
			'\src\db\migration\data\v310\acp_style_components_module',
			'\src\db\migration\data\v310\allow_cdn',
			'\src\db\migration\data\v310\auth_provider_oauth',
			'\src\db\migration\data\v310\avatars',
			'\src\db\migration\data\v310\srcrdindex',
			'\src\db\migration\data\v310\config_db_text',
			'\src\db\migration\data\v310\forgot_password',
			'\src\db\migration\data\v310\mod_rewrite',
			'\src\db\migration\data\v310\mysql_fulltext_drop',
			'\src\db\migration\data\v310\namespaces',
			'\src\db\migration\data\v310\notifications_cron',
			'\src\db\migration\data\v310\notification_options_reconvert',
			'\src\db\migration\data\v310\plupload',
			'\src\db\migration\data\v310\signature_module_auth',
			'\src\db\migration\data\v310\softdelete_mcp_modules',
			'\src\db\migration\data\v310\teampage',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('version', '3.1.0-a1')),
		);
	}
}
