<?php

namespace src;

/**
* A class with various functions that are related to paths, files and the filesystem
*/
class filesystem
{
	/**
	* Eliminates useless . and .. components from specified path.
	*
	* @param string $path Path to clean
	* @return string Cleaned path
	*/
	public function clean_path($path)
	{
		$exploded = explode('/', $path);
		$filtered = array();
		foreach ($exploded as $part)
		{
			if ($part === '.' && !empty($filtered))
			{
				continue;
			}

			if ($part === '..' && !empty($filtered) && $filtered[sizeof($filtered) - 1] !== '.' && $filtered[sizeof($filtered) - 1] !== '..')
			{
				array_pop($filtered);
			}
			else
			{
				$filtered[] = $part;
			}
		}
		$path = implode('/', $filtered);
		return $path;
	}
}
