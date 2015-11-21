<?php

namespace src\event;

use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\Event;

class dispatcher extends ContainerAwareEventDispatcher implements dispatcher_interface
{
	/**
	 * @var bool
	 */
	protected $disabled = false;

	/**
	* {@inheritdoc}
	*/
	public function trigger_event($eventName, $data = array())
	{
		$event = new \src\event\data($data);
		$this->dispatch($eventName, $event);
		return $event->get_data_filtered(array_keys($data));
	}

	/**
	 * {@inheritdoc}
	 */
	public function dispatch($eventName, Event $event = null)
	{
		if ($this->disabled)
		{
			return $event;
		}

		return parent::dispatch($eventName, $event);
	}

	/**
	 * {@inheritdoc}
	 */
	public function disable()
	{
		$this->disabled = true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function enable()
	{
		$this->disabled = false;
	}
}
