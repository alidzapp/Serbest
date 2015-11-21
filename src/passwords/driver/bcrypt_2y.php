<?php

namespace src\passwords\driver;

class bcrypt_2y extends bcrypt
{
	const PREFIX = '$2y$';

	/**
	* {@inheritdoc}
	*/
	public function get_prefix()
	{
		return self::PREFIX;
	}

	/**
	* {@inheritdoc}
	*/
	public function is_supported()
	{
		return (version_compare(PHP_VERSION, '5.3.7', '<')) ? false : true;
	}
}
