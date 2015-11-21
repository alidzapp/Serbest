<?php

namespace src;

/**
* Class to handle viewonline related tasks
*/
class viewonline_helper
{
	/** @var \src\filesystem */
	protected $filesystem;

	/**
	* @param \src\filesystem $filesystem
	*/
	public function __construct(\src\filesystem $filesystem)
	{
		$this->filesystem = $filesystem;
	}

	/**
	* Get user page
	*
	* @param string $session_page User's session page
	* @return array Match array filled by preg_match()
	*/
	public function get_user_page($session_page)
	{
		$session_page = $this->filesystem->clean_path($session_page);
		if (strpos($session_page, './') === 0)
		{
			$session_page = substr($session_page, 2);
		}

		preg_match('#^((\.\./)*([a-z0-9/_-]+))#i', $session_page, $on_page);
		if (empty($on_page))
		{
			$on_page[1] = '';
		}

		return $on_page;
	}
}
