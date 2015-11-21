<?php

namespace src\db\migration\data\v30x;

class release_3_0_12_rc3 extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return src_version_compare($this->config['version'], '3.0.12-RC3', '>=') && src_version_compare($this->config['version'], '3.1.0-dev', '<');
	}

	static public function depends_on()
	{
		return array('\src\db\migration\data\v30x\release_3_0_12_rc2');
	}

	public function update_data()
	{
		return array(
			array('if', array(
				src_version_compare($this->config['version'], '3.0.12-RC3', '<'),
				array('config.update', array('version', '3.0.12-RC3')),
			)),
		);
	}
}
