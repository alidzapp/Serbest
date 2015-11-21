<?php

namespace src\di;

/**
* Iterator which loads the services when they are requested
*/
class service_collection_iterator extends \ArrayIterator
{
	/**
	* @var \src\di\service_collection
	*/
	protected $collection;

	/**
	* Construct an ArrayIterator for service_collection
	*
	* @param \src\di\service_collection $collection The collection to iterate over
	* @param int $flags Flags to control the behaviour of the ArrayObject object.
	* @see ArrayObject::setFlags()
	*/
	public function __construct(service_collection $collection, $flags = 0)
	{
		parent::__construct($collection, $flags);
		$this->collection = $collection;
	}

	/**
	* {@inheritdoc}
	*/
	public function current()
	{
		return $this->collection->offsetGet($this->key());
	}
}
