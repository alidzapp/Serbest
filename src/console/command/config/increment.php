<?php

namespace src\console\command\config;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class increment extends command
{
	/**
	* {@inheritdoc}
	*/
	protected function configure()
	{
		$this
			->setName('config:increment')
			->setDescription($this->user->lang('CLI_DESCRIPTION_INCREMENT_CONFIG'))
			->addArgument(
				'key',
				InputArgument::REQUIRED,
				$this->user->lang('CLI_CONFIG_OPTION_NAME')
			)
			->addArgument(
				'increment',
				InputArgument::REQUIRED,
				$this->user->lang('CLI_CONFIG_INCREMENT_BY')
			)
			->addOption(
				'dynamic',
				'd',
				InputOption::VALUE_NONE,
				$this->user->lang('CLI_CONFIG_CANNOT_CACHED')
			)
		;
	}

	/**
	* Executes the command config:increment.
	*
	* Increments an integer configuration value.
	*
	* @param InputInterface  $input  An InputInterface instance
	* @param OutputInterface $output An OutputInterface instance
	*
	* @return null
	* @see \src\config\config::increment()
	*/
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$key = $input->getArgument('key');
		$increment = $input->getArgument('increment');
		$use_cache = !$input->getOption('dynamic');

		$this->config->increment($key, $increment, $use_cache);

		$output->writeln('<info>' . $this->user->lang('CLI_CONFIG_INCREMENT_SUCCESS', $key) . '</info>');
	}
}
