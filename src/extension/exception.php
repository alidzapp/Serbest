<?php

namespace src\extension;

/**
 * Exception class for metadata
 */
class exception extends \UnexpectedValueException
{
	public function __toString()
	{
		return $this->getMessage();
	}
}
