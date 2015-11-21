<?php
namespace src\db\migration\data\v31x;

class profilefield_yahoo_update_url extends \src\db\migration\migration
{
	static public function depends_on()
	{
		return array('\src\db\migration\data\v31x\v312');
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'update_contact_url'))),
		);
	}

	public function update_contact_url()
	{
		$sql = 'UPDATE ' . $this->table_prefix . "profile_fields
			SET field_contact_url = 'ymsgr:sendim?%s'
			WHERE field_name = 'src_yahoo'
				AND field_contact_url = 'http://edit.yahoo.com/config/send_webmesg?.target=%s&amp;.src=pg'";
		$this->sql_query($sql);
	}
}
