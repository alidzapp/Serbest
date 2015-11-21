<?php

namespace src\notification;

/**
* Notifications exception
*/

class exception extends \Exception
{
	public function __toString()
	{
		return $this->getMessage();
	}
}
