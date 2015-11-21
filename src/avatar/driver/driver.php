<?php

namespace src\avatar\driver;

/**
* Base class for avatar drivers
*/
abstract class driver implements \src\avatar\driver\driver_interface
{
	/**
	* Avatar driver name
	* @var string
	*/
	protected $name;

	/**
	* Current srcrd configuration
	* @var \src\config\config
	*/
	protected $config;

	/**
	* Current $src_root_path
	* @var string
	*/
	protected $src_root_path;

	/**
	* Current $php_ext
	* @var string
	*/
	protected $php_ext;

	/**
	* Path Helper
	* @var \src\path_helper
	*/
	protected $path_helper;

	/**
	* Cache driver
	* @var \src\cache\driver\driver_interface
	*/
	protected $cache;

	/**
	* Array of allowed avatar image extensions
	* Array is used for setting the allowed extensions in the fileupload class
	* and as a base for a regex of allowed extensions, which will be formed by
	* imploding the array with a "|".
	*
	* @var array
	*/
	protected $allowed_extensions = array(
		'gif',
		'jpg',
		'jpeg',
		'png',
	);

	/**
	* Construct a driver object
	*
	* @param \src\config\config $config src configuration
	* @param string $src_root_path Path to the src root
	* @param string $php_ext PHP file extension
	* @param \src\path_helper $path_helper src path helper
	* @param \src\cache\driver\driver_interface $cache Cache driver
	*/
	public function __construct(\src\config\config $config, $src_root_path, $php_ext, \src\path_helper $path_helper, \src\cache\driver\driver_interface $cache = null)
	{
		$this->config = $config;
		$this->src_root_path = $src_root_path;
		$this->php_ext = $php_ext;
		$this->path_helper = $path_helper;
		$this->cache = $cache;
	}

	/**
	* {@inheritdoc}
	*/
	public function get_custom_html($user, $row, $alt = '')
	{
		return '';
	}

	/**
	* {@inheritdoc}
	*/
	public function prepare_form_acp($user)
	{
		return array();
	}

	/**
	* {@inheritdoc}
	*/
	public function delete($row)
	{
		return true;
	}

	/**
	* {@inheritdoc}
	*/
	public function get_name()
	{
		return $this->name;
	}

	/**
	* Sets the name of the driver.
	*
	* @param string	$name Driver name
	*/
	public function set_name($name)
	{
		$this->name = $name;
	}
}
