<?php

namespace src\passwords\driver;

abstract class base implements driver_interface
{
	/** @var \src\config\config */
	protected $config;

	/** @var \src\passwords\driver\helper */
	protected $helper;

	/** @var driver name */
	protected $name;

	/**
	* Constructor of passwords driver object
	*
	* @param \src\config\config $config src config
	* @param \src\passwords\driver\helper $helper Password driver helper
	*/
	public function __construct(\src\config\config $config, helper $helper)
	{
		$this->config = $config;
		$this->helper = $helper;
	}

	/**
	* {@inheritdoc}
	*/
	public function is_supported()
	{
		return true;
	}

	/**
	* {@inheritdoc}
	*/
	public function is_legacy()
	{
		return false;
	}

	/**
	* {@inheritdoc}
	*/
	public function get_settings_only($hash, $full = false)
	{
		return false;
	}
}
