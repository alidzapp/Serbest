<?php


namespace src\cron\task;

/**
* Parametrized cron task interface.
*
* Parametrized cron tasks are somewhat of a cross between regular cron tasks and
* delayed jobs. Whereas regular cron tasks perform some action globally,
* parametrized cron tasks perform actions on a particular object (or objects).
* Parametrized cron tasks do not make sense and are not usable without
* specifying these objects.
*/
interface parametrized extends \src\cron\task\task
{
	/**
	* Returns parameters of this cron task as an array.
	*
	* The array must map string keys to string values.
	*
	* @return array
	*/
	public function get_parameters();

	/**
	* Parses parameters found in $request, which is an instance of
	* \src\request\request_interface.
	*
	* $request contains user input and must not be trusted.
	* Cron task must validate all data before using it.
	*
	* @param \src\request\request_interface $request Request object.
	*
	* @return null
	*/
	public function parse_parameters(\src\request\request_interface $request);
}
