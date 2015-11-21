<?php

namespace src\db\migration\data\v310;

/**
* Class captcha_plugin
*
* Reset the captcha setting to the default plugin if the defined 'captcha_plugin' is missing.
*/
class reset_missing_captcha_plugin extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('if', array(
				(is_dir($this->src_root_path . 'includes/captcha/plugins/') &&
				!is_file($this->src_root_path . "includes/captcha/plugins/{$this->config['captcha_plugin']}_plugin." . $this->php_ext)),
				array('config.update', array('captcha_plugin', 'src_captcha_nogd')),
			)),
		);
	}
}
