<?php


namespace src\cron\task\core;

/**
* Tidy cache cron task.
*/
class tidy_cache extends \src\cron\task\base
{
	protected $config;
	protected $cache;

	/**
	* Constructor.
	*
	* @param \src\config\config $config The config
	* @param \src\cache\driver\driver_interface $cache The cache driver
	*/
	public function __construct(\src\config\config $config, \src\cache\driver\driver_interface $cache)
	{
		$this->config = $config;
		$this->cache = $cache;
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		$this->cache->tidy();
	}

	/**
	* Returns whether this cron task can run, given current srcrd configuration.
	*
	* Tidy cache cron task runs if the cache implementation in use
	* supports tidying.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		return true;
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* The interval between cache tidying is specified in srcrd
	* configuration.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['cache_last_gc'] < time() - $this->config['cache_gc'];
	}
}
