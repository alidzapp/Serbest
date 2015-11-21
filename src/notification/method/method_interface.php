<?php


namespace src\notification\method;

/**
* Base notifications method interface
*/
interface method_interface
{
	/**
	* Get notification method name
	*
	* @return string
	*/
	public function get_type();

	/**
	* Is this method available for the user?
	* This is checked on the notifications options
	*/
	public function is_available();

	/**
	* Add a notification to the queue
	*
	* @param \src\notification\type\type_interface $notification
	*/
	public function add_to_queue(\src\notification\type\type_interface $notification);

	/**
	* Parse the queue and notify the users
	*/
	public function notify();
}
