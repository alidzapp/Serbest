<?php

namespace src\console\command\cache;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class purge extends \src\console\command\command
{
	/** @var \src\cache\driver\driver_interface */
	protected $cache;

	/** @var \src\db\driver\driver_interface */
	protected $db;

	/** @var \src\auth\auth */
	protected $auth;

	/** @var \src\log\log_interface */
	protected $log;

	/** @var \src\config\config */
	protected $config;

	/**
	* Constructor
	*
	* @param \src\user							$user	User instance
	* @param \src\cache\driver\driver_interface	$cache	Cache instance
	* @param \src\db\driver\driver_interface		$db		Database connection
	* @param \src\auth\auth						$auth	Auth instance
	* @param \src\log\log							$log	Logger instance
	* @param \src\config\config					$config	Config instance
	*/
	public function __construct(\src\user $user, \src\cache\driver\driver_interface $cache, \src\db\driver\driver_interface $db, \src\auth\auth $auth, \src\log\log_interface $log, \src\config\config $config)
	{
		$this->cache = $cache;
		$this->db = $db;
		$this->auth = $auth;
		$this->log = $log;
		$this->config = $config;
		parent::__construct($user);
	}

	/**
	* {@inheritdoc}
	*/
	protected function configure()
	{
		$this
			->setName('cache:purge')
			->setDescription($this->user->lang('PURGE_CACHE'))
		;
	}

	/**
	* Executes the command cache:purge.
	*
	* Purge the cache (including permissions) and increment the asset_version number
	*
	* @param InputInterface  $input  An InputInterface instance
	* @param OutputInterface $output An OutputInterface instance
	*
	* @return null
	*/
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->config->increment('assets_version', 1);
		$this->cache->purge();

		// Clear permissions
		$this->auth->acl_clear_prefetch();
		src_cache_moderators($this->db, $this->cache, $this->auth);

		$this->log->add('admin', ANONYMOUS, '', 'LOG_PURGE_CACHE', time(), array());

		$output->writeln($this->user->lang('PURGE_CACHE_SUCCESS'));
	}
}
