<?php

namespace src\db;

class null_migrator_output_handler implements migrator_output_handler_interface
{
	/**
	 * {@inheritdoc}
	 */
	public function write($message, $verbosity)
	{
	}
}
