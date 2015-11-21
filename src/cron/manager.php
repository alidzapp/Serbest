<?php


namespace src\cron;

/**
* Cron manager class.
*
* Finds installed cron tasks, stores task objects, provides task selection.
*/
class manager
{
	/**
	* Set of \src\cron\task\wrapper objects.
	* Array holding all tasks that have been found.
	*
	* @var array
	*/
	protected $tasks = array();

	protected $src_root_path;
	protected $php_ext;

	/**
	* Constructor. Loads all available tasks.
	*
	* @param array|\Traversable $tasks Provides an iterable set of task names
	* @param string $src_root_path Relative path to src root
	* @param string $php_ext PHP file extension
	*/
	public function __construct($tasks, $src_root_path, $php_ext)
	{
		$this->src_root_path = $src_root_path;
		$this->php_ext = $php_ext;

		$this->load_tasks($tasks);
	}

	/**
	* Loads tasks given by name, wraps them
	* and puts them into $this->tasks.
	*
	* @param array|\Traversable $tasks		Array of instances of \src\cron\task\task
	*
	* @return null
	*/
	public function load_tasks($tasks)
	{
		foreach ($tasks as $task)
		{
			$this->tasks[] = $this->wrap_task($task);
		}
	}

	/**
	* Finds a task that is ready to run.
	*
	* If several tasks are ready, any one of them could be returned.
	*
	* If no tasks are ready, null is returned.
	*
	* @return \src\cron\task\wrapper|null
	*/
	public function find_one_ready_task()
	{
		shuffle($this->tasks);
		foreach ($this->tasks as $task)
		{
			if ($task->is_ready())
			{
				return $task;
			}
		}
		return null;
	}

	/**
	* Finds all tasks that are ready to run.
	*
	* @return array		List of tasks which are ready to run (wrapped in \src\cron\task\wrapper).
	*/
	public function find_all_ready_tasks()
	{
		$tasks = array();
		foreach ($this->tasks as $task)
		{
			if ($task->is_ready())
			{
				$tasks[] = $task;
			}
		}
		return $tasks;
	}

	/**
	* Finds a task by name.
	*
	* If there is no task with the specified name, null is returned.
	*
	* Web runner uses this method to resolve names to tasks.
	*
	* @param string				$name Name of the task to look up.
	* @return \src\cron\task\task	A task corresponding to the given name, or null.
	*/
	public function find_task($name)
	{
		foreach ($this->tasks as $task)
		{
			if ($task->get_name() == $name)
			{
				return $task;
			}
		}
		return null;
	}

	/**
	* Find all tasks and return them.
	*
	* @return array List of all tasks.
	*/
	public function get_tasks()
	{
		return $this->tasks;
	}

	/**
	* Wraps a task inside an instance of \src\cron\task\wrapper.
	*
	* @param  \src\cron\task\task 			$task The task.
	* @return \src\cron\task\wrapper	The wrapped task.
	*/
	public function wrap_task(\src\cron\task\task $task)
	{
		return new \src\cron\task\wrapper($task, $this->src_root_path, $this->php_ext);
	}
}
