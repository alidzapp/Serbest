<?php

namespace src\passwords\driver;

interface driver_interface
{
	/**
	* Check if hash type is supported
	*
	* @return bool		True if supported, false if not
	*/
	public function is_supported();

	/**
	* Check if hash type is a legacy hash type
	*
	* @return bool		True if it's a legacy hash type, false if not
	*/
	public function is_legacy();

	/**
	* Returns the hash prefix
	*
	* @return string	Hash prefix
	*/
	public function get_prefix();

	/**
	* Hash the password
	*
	* @param string $password The password that should be hashed
	*
	* @return bool|string	Password hash or false if something went wrong
	*			during hashing
	*/
	public function hash($password);

	/**
	* Check the password against the supplied hash
	*
	* @param string		$password The password to check
	* @param string		$hash The password hash to check against
	* @param array		$user_row User's row in users table
	*
	* @return bool		True if password is correct, else false
	*/
	public function check($password, $hash, $user_row = array());

	/**
	* Get only the settings of the specified hash
	*
	* @param string		$hash Password hash
	* @param bool		$full Return full settings or only settings
	*			related to the salt
	* @return string	String containing the hash settings
	*/
	public function get_settings_only($hash, $full = false);
}
