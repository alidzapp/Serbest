<?php

namespace src\console\command\cron;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class cron_list extends \src\console\command\command
{
	/** @var \src\cron\manager */
	protected $cron_manager;

	/**
	* Constructor
	*
	* @param \src\user			$user			User instance
	* @param \src\cron\manager	$cron_manager	Cron manager
	*/
	public function __construct(\src\user $user, \src\cron\manager $cron_manager)
	{
		$this->cron_manager = $cron_manager;
		parent::__construct($user);
	}

	/**
	* {@inheritdoc}
	*/
	protected function configure()
	{
		$this
			->setName('cron:list')
			->setDescription($this->user->lang('CLI_DESCRIPTION_CRON_LIST'))
		;
	}

	/**
	* Executes the command cron:list.
	*
	* Prints a list of ready and unready cron jobs.
	*
	* @param InputInterface  $input  An InputInterface instance
	* @param OutputInterface $output An OutputInterface instance
	*
	* @return null
	*/
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$tasks = $this->cron_manager->get_tasks();

		if (empty($tasks))
		{
			$output->writeln($this->user->lang('CRON_NO_TASKS'));
			return;
		}

		$ready_tasks = array();
		$not_ready_tasks = array();
		foreach ($tasks as $task)
		{
			if ($task->is_ready())
			{
				$ready_tasks[] = $task;
			}
			else
			{
				$not_ready_tasks[] = $task;
			}
		}

		if (!empty($ready_tasks))
		{
			$output->writeln('<info>' . $this->user->lang('TASKS_READY') . '</info>');
			$this->print_tasks_names($ready_tasks, $output);
		}

		if (!empty($ready_tasks) && !empty($not_ready_tasks))
		{
			$output->writeln('');
		}

		if (!empty($not_ready_tasks))
		{
			$output->writeln('<info>' . $this->user->lang('TASKS_NOT_READY') . '</info>');
			$this->print_tasks_names($not_ready_tasks, $output);
		}
	}

	/**
	* Print a list of cron jobs
	*
	* @param array				$tasks A list of task to display
	* @param OutputInterface	$output An OutputInterface instance
	*/
	protected function print_tasks_names(array $tasks, OutputInterface $output)
	{
		foreach ($tasks as $task)
		{
			$output->writeln($task->get_name());
		}
	}
}
