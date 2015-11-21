<?php


namespace src\console\command;

abstract class command extends \Symfony\Component\Console\Command\Command
{
	/** @var \src\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \src\user $user User instance (mostly for translation)
	*/
	public function __construct(\src\user $user)
	{
		$this->user = $user;
		parent::__construct();
	}
}
