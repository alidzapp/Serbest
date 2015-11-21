<?php


namespace src\passwords\driver;

class phpass extends salted_md5
{
	const PREFIX = '$P$';

	/**
	* {@inheritdoc}
	*/
	public function get_prefix()
	{
		return self::PREFIX;
	}
}
