<?php

namespace src\db\migration\data\v310;

class captcha_plugins extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\src\db\migration\data\v310\rc2',
		);
	}

	public function update_data()
	{
		$captcha_plugin = $this->config['captcha_plugin'];
		if (strpos($captcha_plugin, 'src_captcha_') === 0)
		{
			$captcha_plugin = substr($captcha_plugin, strlen('src_captcha_'));
		}
		else if (strpos($captcha_plugin, 'src_') === 0)
		{
			$captcha_plugin = substr($captcha_plugin, strlen('src_'));
		}

		return array(
			array('if', array(
				(is_file($this->src_root_path . 'src/captcha/plugins/' . $captcha_plugin . '.' . $this->php_ext)),
				array('config.update', array('captcha_plugin', 'core.captcha.plugins.' . $captcha_plugin)),
			)),
			array('if', array(
				(!is_file($this->src_root_path . 'src/captcha/plugins/' . $captcha_plugin . '.' . $this->php_ext)),
				array('config.update', array('captcha_plugin', 'core.captcha.plugins.nogd')),
			)),
		);
	}
}
