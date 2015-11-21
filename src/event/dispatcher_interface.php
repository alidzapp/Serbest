<?php
namespace src\event;

interface dispatcher_interface extends \Symfony\Component\EventDispatcher\EventDispatcherInterface
{
	/**
	* Construct and dispatch an event
	*
	* @param string $eventName	The event name
	* @param array $data		An array containing the variables sending with the event
	* @return mixed
	*/
	public function trigger_event($eventName, $data = array());

	/**
	 * Disable the event dispatcher.
	 */
	public function disable();

	/**
	 * Enable the event dispatcher.
	 */
	public function enable();
}
