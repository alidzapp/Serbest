<?php

namespace src\passwords\driver;

class sha1 extends base
{
	const PREFIX = '$sha1$';

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
	public function is_legacy()
	{
		return true;
	}

	/**
	* {@inheritdoc}
	*/
	public function hash($password, $user_row = '')
	{
		// Do not support hashing
		return false;
	}

	/**
	* {@inheritdoc}
	*/
	public function check($password, $hash, $user_row = array())
	{
		return (strlen($hash) == 40) ? $this->helper->string_compare($hash, sha1($password)) : false;
	}
}
