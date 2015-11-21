<?php

namespace src\cron\task\core;

/**
* Prune all forums cron task.
*
* It is intended to be invoked from system cron.
* This task will find all forums for which pruning is enabled, and will
* prune all forums as necessary.
*/
class prune_all_forums extends \src\cron\task\base
{
	protected $src_root_path;
	protected $php_ext;
	protected $config;
	protected $db;

	/**
	* Constructor.
	*
	* @param string $src_root_path The root path
	* @param string $php_ext The PHP file extension
	* @param \src\config\config $config The config
	* @param \src\db\driver\driver_interface $db The db connection
	*/
	public function __construct($src_root_path, $php_ext, \src\config\config $config, \src\db\driver\driver_interface $db)
	{
		$this->src_root_path = $src_root_path;
		$this->php_ext = $php_ext;
		$this->config = $config;
		$this->db = $db;
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		if (!function_exists('auto_prune'))
		{
			include($this->src_root_path . 'includes/functions_admin.' . $this->php_ext);
		}

		$sql = 'SELECT forum_id, prune_next, enable_prune, prune_days, prune_viewed, forum_flags, prune_freq
			FROM ' . FORUMS_TABLE . "
			WHERE enable_prune = 1
				AND prune_next < " . time();
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($row['prune_days'])
			{
				auto_prune($row['forum_id'], 'posted', $row['forum_flags'], $row['prune_days'], $row['prune_freq']);
			}

			if ($row['prune_viewed'])
			{
				auto_prune($row['forum_id'], 'viewed', $row['forum_flags'], $row['prune_viewed'], $row['prune_freq']);
			}
		}
		$this->db->sql_freeresult($result);
	}

	/**
	* Returns whether this cron task can run, given current srcrd configuration.
	*
	* This cron task will only run when system cron is utilised.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		return (bool) $this->config['use_system_cron'];
	}
}
