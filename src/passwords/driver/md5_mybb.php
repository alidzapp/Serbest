<?php

namespace src\passwords\driver;

class md5_mybb extends base
{
	const PREFIX = '$md5_mybb$';

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
		if (empty($hash) || strlen($hash) != 32 || !isset($user_row['user_passwd_salt']))
		{
			return false;
		}
		else
		{
			// Works for myBB 1.1.x, 1.2.x, 1.4.x, 1.6.x
			return $this->helper->string_compare($hash, md5(md5($user_row['user_passwd_salt']) . md5($password)));
		}
	}
}
