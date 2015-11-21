<?php

namespace src\cron\task\core;

/**
* Tidy warnings cron task.
*
* Will only run when warnings are configured to expire.
*/
class tidy_warnings extends \src\cron\task\base
{
	protected $src_root_path;
	protected $php_ext;
	protected $config;

	/**
	* Constructor.
	*
	* @param string $src_root_path The root path
	* @param string $php_ext PHP file extension
	* @param \src\config\config $config The config
	*/
	public function __construct($src_root_path, $php_ext, \src\config\config $config)
	{
		$this->src_root_path = $src_root_path;
		$this->php_ext = $php_ext;
		$this->config = $config;
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		if (!function_exists('tidy_warnings'))
		{
			include($this->src_root_path . 'includes/functions_admin.' . $this->php_ext);
		}
		tidy_warnings();
	}

	/**
	* Returns whether this cron task can run, given current srcrd configuration.
	*
	* If warnings are set to never expire, this cron task will not run.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		return (bool) $this->config['warnings_expire_days'];
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* The interval between warnings tidying is specified in srcrd
	* configuration.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['warnings_last_gc'] < time() - $this->config['warnings_gc'];
	}
}
