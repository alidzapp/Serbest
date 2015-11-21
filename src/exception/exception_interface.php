<?php

namespace src\exception;

/**
 * Interface exception_interface
 *
 * Define an exception which support a language var as message.
 */
interface exception_interface
{
	/**
	 * Return the arguments associated with the message if it's a language var.
	 *
	 * @return array
	 */
	public function get_parameters();
}
