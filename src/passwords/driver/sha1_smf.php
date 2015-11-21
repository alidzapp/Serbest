<?php

namespace src\passwords\driver;

class sha1_smf extends base
{
	const PREFIX = '$smf$';

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
		return (isset($user_row['login_name'])) ? sha1(strtolower($user_row['login_name']) . $password) : false;
	}

	/**
	* {@inheritdoc}
	*/
	public function check($password, $hash, $user_row = array())
	{
		return (strlen($hash) == 40) ? $this->helper->string_compare($hash, $this->hash($password, $user_row)) : false;
	}
}
