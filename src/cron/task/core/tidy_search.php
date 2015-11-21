<?php

namespace src\cron\task\core;

/**
* Tidy search cron task.
*
* Will only run when the currently selected search backend supports tidying.
*/
class tidy_search extends \src\cron\task\base
{
	protected $src_root_path;
	protected $php_ext;
	protected $auth;
	protected $config;
	protected $db;
	protected $user;

	/**
	* Constructor.
	*
	* @param string $src_root_path The root path
	* @param string $php_ext The PHP file extension
	* @param \src\auth\auth $auth The auth
	* @param \src\config\config $config The config
	* @param \src\db\driver\driver_interface $db The db connection
	* @param \src\user $user The user
	*/
	public function __construct($src_root_path, $php_ext, \src\auth\auth $auth, \src\config\config $config, \src\db\driver\driver_interface $db, \src\user $user)
	{
		$this->src_root_path = $src_root_path;
		$this->php_ext = $php_ext;
		$this->auth = $auth;
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		$search_type = $this->config['search_type'];

		// We do some additional checks in the module to ensure it can actually be utilised
		$error = false;
		$search = new $search_type($error, $this->src_root_path, $this->php_ext, $this->auth, $this->config, $this->db, $this->user);

		if (!$error)
		{
			$search->tidy();
		}
	}

	/**
	* Returns whether this cron task can run, given current srcrd configuration.
	*
	* Search cron task is runnable in all normal use. It may not be
	* runnable if the search backend implementation selected in srcrd
	* configuration does not exist.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		return class_exists($this->config['search_type']);
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* The interval between search tidying is specified in srcrd
	* configuration.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['search_last_gc'] < time() - $this->config['search_gc'];
	}
}
