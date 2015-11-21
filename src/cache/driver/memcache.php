<?php


namespace src\cache\driver;

if (!defined('src_ACM_MEMCACHE_PORT'))
{
	define('src_ACM_MEMCACHE_PORT', 11211);
}

if (!defined('src_ACM_MEMCACHE_COMPRESS'))
{
	define('src_ACM_MEMCACHE_COMPRESS', false);
}

if (!defined('src_ACM_MEMCACHE_HOST'))
{
	define('src_ACM_MEMCACHE_HOST', 'localhost');
}

if (!defined('src_ACM_MEMCACHE'))
{
	//can define multiple servers with host1/port1,host2/port2 format
	define('src_ACM_MEMCACHE', src_ACM_MEMCACHE_HOST . '/' . src_ACM_MEMCACHE_PORT);
}

/**
* ACM for Memcached
*/
class memcache extends \src\cache\driver\memory
{
	var $extension = 'memcache';

	var $memcache;
	var $flags = 0;

	function __construct()
	{
		// Call the parent constructor
		parent::__construct();

		$this->memcache = new \Memcache;
		foreach(explode(',', src_ACM_MEMCACHE) as $u)
		{
			$parts = explode('/', $u);
			$this->memcache->addServer(trim($parts[0]), trim($parts[1]));
		}
		$this->flags = (src_ACM_MEMCACHE_COMPRESS) ? MEMCACHE_COMPRESSED : 0;
	}

	/**
	* {@inheritDoc}
	*/
	function unload()
	{
		parent::unload();

		$this->memcache->close();
	}

	/**
	* {@inheritDoc}
	*/
	function purge()
	{
		$this->memcache->flush();

		parent::purge();
	}

	/**
	* Fetch an item from the cache
	*
	* @access protected
	* @param string $var Cache key
	* @return mixed Cached data
	*/
	function _read($var)
	{
		return $this->memcache->get($this->key_prefix . $var);
	}

	/**
	* Store data in the cache
	*
	* @access protected
	* @param string $var Cache key
	* @param mixed $data Data to store
	* @param int $ttl Time-to-live of cached data
	* @return bool True if the operation succeeded
	*/
	function _write($var, $data, $ttl = 2592000)
	{
		if (!$this->memcache->replace($this->key_prefix . $var, $data, $this->flags, $ttl))
		{
			return $this->memcache->set($this->key_prefix . $var, $data, $this->flags, $ttl);
		}
		return true;
	}

	/**
	* Remove an item from the cache
	*
	* @access protected
	* @param string $var Cache key
	* @return bool True if the operation succeeded
	*/
	function _delete($var)
	{
		return $this->memcache->delete($this->key_prefix . $var);
	}
}
