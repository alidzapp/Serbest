<?php

namespace src\console\command\config;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class set extends command
{
	/**
	* {@inheritdoc}
	*/
	protected function configure()
	{
		$this
			->setName('config:set')
			->setDescription($this->user->lang('CLI_DESCRIPTION_SET_CONFIG'))
			->addArgument(
				'key',
				InputArgument::REQUIRED,
				$this->user->lang('CLI_CONFIG_OPTION_NAME')
			)
			->addArgument(
				'value',
				InputArgument::REQUIRED,
				$this->user->lang('CLI_CONFIG_NEW')
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
	* Executes the command config:set.
	*
	* Sets a configuration option's value.
	*
	* @param InputInterface  $input  An InputInterface instance
	* @param OutputInterface $output An OutputInterface instance
	*
	* @return null
	* @see \src\config\config::set()
	*/
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$key = $input->getArgument('key');
		$value = $input->getArgument('value');
		$use_cache = !$input->getOption('dynamic');

		$this->config->set($key, $value, $use_cache);

		$output->writeln('<info>' . $this->user->lang('CLI_CONFIG_SET_SUCCESS', $key) . '</info>');
	}
}
