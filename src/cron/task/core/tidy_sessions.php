<?php


namespace src\cron\task\core;

/**
* Tidy sessions cron task.
*/
class tidy_sessions extends \src\cron\task\base
{
	protected $config;
	protected $user;

	/**
	* Constructor.
	*
	* @param \src\config\config $config The config
	* @param \src\user $user The user
	*/
	public function __construct(\src\config\config $config, \src\user $user)
	{
		$this->config = $config;
		$this->user = $user;
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		$this->user->session_gc();
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* The interval between session tidying is specified in srcrd
	* configuration.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['session_last_gc'] < time() - $this->config['session_gc'];
	}
}
