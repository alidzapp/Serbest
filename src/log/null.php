<?php

namespace src\log;

/**
* Null logger
*/
class null implements log_interface
{
	/**
	* {@inheritdoc}
	*/
	public function is_enabled($type = '')
	{
		return false;
	}

	/**
	* {@inheritdoc}
	*/
	public function disable($type = '')
	{
	}

	/**
	* {@inheritdoc}
	*/
	public function enable($type = '')
	{
	}

	/**
	* {@inheritdoc}
	*/
	public function add($mode, $user_id, $log_ip, $log_operation, $log_time = false, $additional_data = array())
	{
		return false;
	}

	/**
	* {@inheritdoc}
	*/
	public function delete($mode, $conditions = array())
	{
	}

	/**
	* {@inheritdoc}
	*/
	public function get_logs($mode, $count_logs = true, $limit = 0, $offset = 0, $forum_id = 0, $topic_id = 0, $user_id = 0, $log_time = 0, $sort_by = 'l.log_time DESC', $keywords = '')
	{
		return array();
	}

	/**
	* {@inheritdoc}
	*/
	public function get_log_count()
	{
		return 0;
	}

	/**
	* {@inheritdoc}
	*/
	public function get_valid_offset()
	{
		return 0;
	}
}
