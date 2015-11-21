<?php

namespace src\console\command\extension;

abstract class command extends \src\console\command\command
{
	/** @var \src\extension\manager */
	protected $manager;

	/** @var \src\log\log */
	protected $log;

	public function __construct(\src\user $user, \src\extension\manager $manager, \src\log\log $log)
	{
		$this->manager = $manager;
		$this->log = $log;

		parent::__construct($user);
	}
}
