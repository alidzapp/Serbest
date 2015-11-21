<?php

namespace src\console\command\extension;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class disable extends command
{
	protected function configure()
	{
		$this
			->setName('extension:disable')
			->setDescription($this->user->lang('CLI_DESCRIPTION_DISABLE_EXTENSION'))
			->addArgument(
				'extension-name',
				InputArgument::REQUIRED,
				$this->user->lang('CLI_EXTENSION_NAME')
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$name = $input->getArgument('extension-name');
		$this->manager->disable($name);
		$this->manager->load_extensions();

		if ($this->manager->is_enabled($name))
		{
			$output->writeln('<error>' . $this->user->lang('CLI_EXTENSION_DISABLE_FAILURE', $name) . '</error>');
			return 1;
		}
		else
		{
			$this->log->add('admin', ANONYMOUS, '', 'LOG_EXT_DISABLE', time(), array($name));
			$output->writeln('<info>' . $this->user->lang('CLI_EXTENSION_DISABLE_SUCCESS', $name) . '</info>');
			return 0;
		}
	}
}
