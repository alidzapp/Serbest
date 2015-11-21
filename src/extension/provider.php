<?php

namespace src\extension;

abstract class provider implements \IteratorAggregate
{
	/**
	* Array holding all found items
	* @var array|null
	*/
	protected $items = null;

	/**
	* An extension manager to search for items in extensions
	* @var \src\extension\manager
	*/
	protected $extension_manager;

	/**
	* Constructor. Loads all available items.
	*
	* @param \src\extension\manager $extension_manager src extension manager
	*/
	public function __construct(\src\extension\manager $extension_manager)
	{
		$this->extension_manager = $extension_manager;
	}

	/**
	* Finds items using the extension manager.
	*
	* @return array     List of task names
	*/
	abstract protected function find();

	/**
	* Retrieve an iterator over all items
	*
	* @return \ArrayIterator An iterator for the array of template paths
	*/
	public function getIterator()
	{
		if ($this->items === null)
		{
			$this->items = $this->find();
		}

		return new \ArrayIterator($this->items);
	}
}
