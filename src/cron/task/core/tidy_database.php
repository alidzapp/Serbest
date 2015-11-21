<?php


namespace src\cron\task\core;

/**
* Tidy database cron task.
*/
class tidy_database extends \src\cron\task\base
{
	protected $src_root_path;
	protected $php_ext;
	protected $config;

	/**
	* Constructor.
	*
	* @param string $src_root_path The root path
	* @param string $php_ext The PHP file extension
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
		if (!function_exists('tidy_database'))
		{
			include($this->src_root_path . 'includes/functions_admin.' . $this->php_ext);
		}
		tidy_database();
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* The interval between database tidying is specified in srcrd
	* configuration.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['database_last_gc'] < time() - $this->config['database_gc'];
	}
}
