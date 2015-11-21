<?php

namespace src\console\command\config;

abstract class command extends \src\console\command\command
{
	/** @var \src\config\config */
	protected $config;

	function __construct(\src\user $user, \src\config\config $config)
	{
		$this->config = $config;

		parent::__construct($user);
	}
}
