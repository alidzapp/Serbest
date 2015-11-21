<?php

namespace src\console\command\db;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class migrate extends \src\console\command\command
{
	/** @var \src\db\migrator */
	protected $migrator;

	/** @var \src\extension\manager */
	protected $extension_manager;

	/** @var \src\config\config */
	protected $config;

	/** @var \src\cache\service */
	protected $cache;

	/** @var \src\log\log */
	protected $log;

	/** @var string src root path */
	protected $src_root_path;

	function __construct(\src\user $user, \src\db\migrator $migrator, \src\extension\manager $extension_manager, \src\config\config $config, \src\cache\service $cache, \src\log\log $log, $src_root_path)
	{
		$this->migrator = $migrator;
		$this->extension_manager = $extension_manager;
		$this->config = $config;
		$this->cache = $cache;
		$this->log = $log;
		$this->src_root_path = $src_root_path;
		parent::__construct($user);
		$this->user->add_lang(array('common', 'install', 'migrator'));
	}

	protected function configure()
	{
		$this
			->setName('db:migrate')
			->setDescription($this->user->lang('CLI_DESCRIPTION_DB_MIGRATE'))
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->migrator->set_output_handler(new \src\db\log_wrapper_migrator_output_handler($this->user, new console_migrator_output_handler($this->user, $output), $this->src_root_path . 'store/migrations_' . time() . '.log'));

		$this->migrator->create_migrations_table();

		$this->cache->purge();

		$this->load_migrations();
		$orig_version = $this->config['version'];
		while (!$this->migrator->finished())
		{
			try
			{
				$this->migrator->update();
			}
			catch (\src\db\migration\exception $e)
			{
				$output->writeln('<error>' . $e->getLocalisedMessage($this->user) . '</error>');
				$this->finalise_update();
				return 1;
			}
		}

		if ($orig_version != $this->config['version'])
		{
			$this->log->add('admin', ANONYMOUS, '', 'LOG_UPDATE_DATABASE', time(), array($orig_version, $this->config['version']));
		}

		$this->finalise_update();
		$output->writeln($this->user->lang['DATABASE_UPDATE_COMPLETE']);
	}

	protected function load_migrations()
	{
		$migrations = $this->extension_manager
			->get_finder()
			->core_path('src/db/migration/data/')
			->extension_directory('/migrations')
			->get_classes();

		$this->migrator->set_migrations($migrations);
	}

	protected function finalise_update()
	{
		$this->cache->purge();
		$this->config->increment('assets_version', 1);
	}
}
