<?php


namespace src\cache\driver;

abstract class base implements \src\cache\driver\driver_interface
{
	var $vars = array();
	var $is_modified = false;

	var $sql_rowset = array();
	var $sql_row_pointer = array();
	var $cache_dir = '';

	/**
	* {@inheritDoc}
	*/
	function purge()
	{
		// Purge all src cache files
		try
		{
			$iterator = new \DirectoryIterator($this->cache_dir);
		}
		catch (\Exception $e)
		{
			return;
		}

		foreach ($iterator as $fileInfo)
		{
			if ($fileInfo->isDot())
			{
				continue;
			}
			$filename = $fileInfo->getFilename();
			if ($fileInfo->isDir())
			{
				$this->remove_dir($fileInfo->getPathname());
			}
			else if (strpos($filename, 'container_') === 0 ||
				strpos($filename, 'url_matcher') === 0 ||
				strpos($filename, 'sql_') === 0 ||
				strpos($filename, 'data_') === 0)
			{
				$this->remove_file($fileInfo->getPathname());
			}
		}

		unset($this->vars);
		unset($this->sql_rowset);
		unset($this->sql_row_pointer);

		$this->vars = array();
		$this->sql_rowset = array();
		$this->sql_row_pointer = array();

		$this->is_modified = false;
	}

	/**
	* {@inheritDoc}
	*/
	function unload()
	{
		$this->save();
		unset($this->vars);
		unset($this->sql_rowset);
		unset($this->sql_row_pointer);

		$this->vars = array();
		$this->sql_rowset = array();
		$this->sql_row_pointer = array();
	}

	/**
	* {@inheritDoc}
	*/
	function sql_load($query)
	{
		// Remove extra spaces and tabs
		$query = preg_replace('/[\n\r\s\t]+/', ' ', $query);

		if (($rowset = $this->_read('sql_' . md5($query))) === false)
		{
			return false;
		}

		$query_id = sizeof($this->sql_rowset);
		$this->sql_rowset[$query_id] = $rowset;
		$this->sql_row_pointer[$query_id] = 0;

		return $query_id;
	}

	/**
	* {@inheritDoc}
	*/
	function sql_exists($query_id)
	{
		return isset($this->sql_rowset[$query_id]);
	}

	/**
	* {@inheritDoc}
	*/
	function sql_fetchrow($query_id)
	{
		if ($this->sql_row_pointer[$query_id] < sizeof($this->sql_rowset[$query_id]))
		{
			return $this->sql_rowset[$query_id][$this->sql_row_pointer[$query_id]++];
		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	function sql_fetchfield($query_id, $field)
	{
		if ($this->sql_row_pointer[$query_id] < sizeof($this->sql_rowset[$query_id]))
		{
			return (isset($this->sql_rowset[$query_id][$this->sql_row_pointer[$query_id]][$field])) ? $this->sql_rowset[$query_id][$this->sql_row_pointer[$query_id]++][$field] : false;
		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	function sql_rowseek($rownum, $query_id)
	{
		if ($rownum >= sizeof($this->sql_rowset[$query_id]))
		{
			return false;
		}

		$this->sql_row_pointer[$query_id] = $rownum;
		return true;
	}

	/**
	* {@inheritDoc}
	*/
	function sql_freeresult($query_id)
	{
		if (!isset($this->sql_rowset[$query_id]))
		{
			return false;
		}

		unset($this->sql_rowset[$query_id]);
		unset($this->sql_row_pointer[$query_id]);

		return true;
	}

	/**
	* Removes/unlinks file
	*
	* @param string $filename Filename to remove
	* @param bool $check Check file permissions
	* @return bool True if the file was successfully removed, otherwise false
	*/
	function remove_file($filename, $check = false)
	{
		if (!function_exists('src_is_writable'))
		{
			global $src_root_path, $phpEx;
			include($src_root_path . 'includes/functions.' . $phpEx);
		}

		if ($check && !src_is_writable($this->cache_dir))
		{
			// E_USER_ERROR - not using language entry - intended.
			trigger_error('Unable to remove files within ' . $this->cache_dir . '. Please check directory permissions.', E_USER_ERROR);
		}

		return @unlink($filename);
	}

	/**
	* Remove directory
	*
	* @param string $dir Directory to remove
	*
	* @return null
	*/
	protected function remove_dir($dir)
	{
		try
		{
			$iterator = new \DirectoryIterator($dir);
		}
		catch (\Exception $e)
		{
			return;
		}

		foreach ($iterator as $fileInfo)
		{
			if ($fileInfo->isDot())
			{
				continue;
			}

			if ($fileInfo->isDir())
			{
				$this->remove_dir($fileInfo->getPathname());
			}
			else
			{
				$this->remove_file($fileInfo->getPathname());
			}
		}

		@rmdir($dir);
	}
}
