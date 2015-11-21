<?php

namespace src\console\command\dev;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class migration_tips extends \src\console\command\command
{
	/** @var \src\extension\manager */
	protected $extension_manager;

	function __construct(\src\user $user, \src\extension\manager $extension_manager)
	{
		$this->extension_manager = $extension_manager;
		parent::__construct($user);
	}

	protected function configure()
	{
		$this
			->setName('dev:migration-tips')
			->setDescription($this->user->lang('CLI_DESCRIPTION_FIND_MIGRATIONS'))
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$migrations = $this->extension_manager->get_finder()
			->set_extensions(array())
			->core_path('src/db/migration/data/')
			->get_classes();
		$tips = $migrations;

		foreach ($migrations as $migration_class)
		{
			foreach ($migration_class::depends_on() as $dependency)
			{
				$tips_key = array_search($dependency, $tips);
				if ($tips_key !== false)
				{
					unset($tips[$tips_key]);
				}
			}
		}

		$output->writeln("\t\tarray(");
		foreach ($tips as $migration)
		{
			$output->writeln("\t\t\t'{$migration}',");
		}
		$output->writeln("\t\t);");
	}
}
