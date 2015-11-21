<?php
namespace src\db\migration\data\v30x;

class release_3_0_4 extends \src\db\migration\migration
{
	public function effectively_installed()
	{
		return src_version_compare($this->config['version'], '3.0.4', '>=');
	}

	static public function depends_on()
	{
		return array('\src\db\migration\data\v30x\release_3_0_4_rc1');
	}

	public function update_data()
	{
		return array(
			array('custom', array(array(&$this, 'rename_log_delete_topic'))),

			array('config.update', array('version', '3.0.4')),
		);
	}

	public function rename_log_delete_topic()
	{
		if ($this->db->get_sql_layer() == 'oracle')
		{
			// log_operation is CLOB - but we can change this later
			$sql = 'UPDATE ' . $this->table_prefix . "log
				SET log_operation = 'LOG_DELETE_TOPIC'
				WHERE log_operation LIKE 'LOG_TOPIC_DELETED'";
			$this->sql_query($sql);
		}
		else
		{
			$sql = 'UPDATE ' . $this->table_prefix . "log
				SET log_operation = 'LOG_DELETE_TOPIC'
				WHERE log_operation = 'LOG_TOPIC_DELETED'";
			$this->sql_query($sql);
		}
	}
}
