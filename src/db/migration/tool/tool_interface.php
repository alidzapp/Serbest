<?php

namespace src\db\migration\tool;

/**
* Migration tool interface
*/
interface tool_interface
{
	/**
	* Retrieve a short name used for commands in migrations.
	*
	* @return string short name
	*/
	public function get_name();

	/**
	* Reverse an original install action
	*
	* First argument is the original call to the class (e.g. add, remove)
	* After the first argument, send the original arguments to the function in the original call
	*
	* @return null
	*/
	public function reverse();
}
