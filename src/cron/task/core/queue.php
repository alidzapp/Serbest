<?php

namespace src\cron\task\core;

/**
* Queue cron task. Sends email and jabber messages queued by other scripts.
*/
class queue extends \src\cron\task\base
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
		if (!class_exists('queue'))
		{
			include($this->src_root_path . 'includes/functions_messenger.' . $this->php_ext);
		}
		$queue = new \queue();
		$queue->process();
	}

	/**
	* Returns whether this cron task can run, given current srcrd configuration.
	*
	* Queue task is only run if the email queue (file) exists.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		return file_exists($this->src_root_path . 'cache/queue.' . $this->php_ext);
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* The interval between queue runs is specified in srcrd configuration.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['last_queue_run'] < time() - $this->config['queue_interval'];
	}
}
