<?php

namespace src\mimetype;

abstract class guesser_base implements guesser_interface
{
	/**
	* @var int Guesser Priority
	*/
	protected $priority;

	/**
	* {@inheritdoc}
	*/
	public function get_priority()
	{
		return $this->priority;
	}

	/**
	* {@inheritdoc}
	*/
	public function set_priority($priority)
	{
		$this->priority = $priority;
	}
}
