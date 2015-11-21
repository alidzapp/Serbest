<?php


namespace src\console;

use Symfony\Component\Console\Shell;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class application extends \Symfony\Component\Console\Application
{
	/**
	* @var bool Indicates whether or not we are in a shell
	*/
	protected $in_shell = false;

	/**
	* @var \src\user User object
	*/
	protected $user;

	/**
	* @param string			$name		The name of the application
	* @param string			$version	The version of the application
	* @param \src\user	$user		The user which runs the application (used for translation)
	*/
	public function __construct($name, $version, \src\user $user)
	{
		$this->user = $user;

		parent::__construct($name, $version);
	}

	/**
	* {@inheritdoc}
	*/
	protected function getDefaultInputDefinition()
	{
		$input_definition = parent::getDefaultInputDefinition();

		$input_definition->addOption(new InputOption(
			'safe-mode',
			null,
			InputOption::VALUE_NONE,
			$this->user->lang('CLI_DESCRIPTION_OPTION_SAFE_MODE')
		));

		return $input_definition;
	}

	/**
	* Gets the help message.
	*
	* It's a hack of the default help message to display the --shell
	* option only for the application and not for all the commands.
	*
	* @return string A help message.
	*/
	public function getHelp()
	{
		// If we are already in a shell
		// we do not want to have the --shell option available
		if ($this->in_shell)
		{
			return parent::getHelp();
		}

		$this->getDefinition()->addOption(new InputOption(
			'--shell',
			'-s',
			InputOption::VALUE_NONE,
			$this->user->lang('CLI_DESCRIPTION_OPTION_SHELL')
		));

		return parent::getHelp();
	}

	/**
	* Register a set of commands from the container
	*
	* @param \src\di\service_collection	$command_collection	The console service collection
	*/
	public function register_container_commands(\src\di\service_collection $command_collection)
	{
		foreach ($command_collection as $service_command)
		{
			$this->add($service_command);
		}
	}

	/**
	* {@inheritdoc}
	*/
	public function doRun(InputInterface $input, OutputInterface $output)
	{
		// Run a shell if the --shell (or -s) option is set and if no command name is specified
		// Also, we do not want to have the --shell option available if we are already in a shell
		if (!$this->in_shell && $this->getCommandName($input) === null && $input->hasParameterOption(array('--shell', '-s')))
		{
			$shell = new Shell($this);
			$this->in_shell = true;
			$shell->run();

			return 0;
		}

		return parent::doRun($input, $output);
	}
}
