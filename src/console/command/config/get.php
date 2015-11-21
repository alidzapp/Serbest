<?php

namespace src\console\command\config;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class get extends command
{
	/**
	* {@inheritdoc}
	*/
	protected function configure()
	{
		$this
			->setName('config:get')
			->setDescription($this->user->lang('CLI_DESCRIPTION_GET_CONFIG'))
			->addArgument(
				'key',
				InputArgument::REQUIRED,
				$this->user->lang('CLI_CONFIG_OPTION_NAME')
			)
			->addOption(
				'no-newline',
				null,
				InputOption::VALUE_NONE,
				$this->user->lang('CLI_CONFIG_PRINT_WITHOUT_NEWLINE')
			)
		;
	}

	/**
	* Executes the command config:get.
	*
	* Retrieves a configuration value.
	*
	* @param InputInterface  $input  An InputInterface instance
	* @param OutputInterface $output An OutputInterface instance
	*
	* @return null
	* @see \src\config\config::offsetGet()
	*/
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$key = $input->getArgument('key');

		if (isset($this->config[$key]) && $input->getOption('no-newline'))
		{
			$output->write($this->config[$key]);
		}
		else if (isset($this->config[$key]))
		{
			$output->writeln($this->config[$key]);
		}
		else
		{
			$output->writeln('<error>' . $this->user->lang('CLI_CONFIG_NOT_EXISTS', $key) . '</error>');
		}
	}
}
