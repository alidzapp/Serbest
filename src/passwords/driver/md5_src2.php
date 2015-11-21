<?php

namespace src\passwords\driver;

class md5_src2 extends base
{
	const PREFIX = '$md5_src2$';

	/** @var \src\request\request src request object */
	protected $request;

	/** @var \src\passwords\driver\salted_md5 */
	protected $salted_md5;

	/** @var \src\passwords\driver\helper */
	protected $helper;

	/** @var string src root path */
	protected $src_root_path;

	/** @var string php file extension */
	protected $php_ext;

	/**
	* Constructor of passwords driver object
	*
	* @param \src\request\request $request src request object
	* @param \src\passwords\driver\salted_md5 $salted_md5 Salted md5 driver
	 * @param \src\passwords\driver\helper $helper Driver helper
	* @param string $src_root_path src root path
	* @param string $php_ext PHP file extension
	*/
	public function __construct($request, salted_md5 $salted_md5, helper $helper, $src_root_path, $php_ext)
	{
		$this->request = $request;
		$this->salted_md5 = $salted_md5;
		$this->helper = $helper;
		$this->src_root_path = $src_root_path;
		$this->php_ext = $php_ext;
	}

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
		if (strlen($hash) != 32 && strlen($hash) != 34)
		{
			return false;
		}

		// enable super globals to get literal value
		// this is needed to prevent unicode normalization
		$super_globals_disabled = $this->request->super_globals_disabled();
		if ($super_globals_disabled)
		{
			$this->request->enable_super_globals();
		}

		// in src2 passwords were used exactly as they were sent, with addslashes applied
		$password_old_format = isset($_REQUEST['password']) ? (string) $_REQUEST['password'] : '';
		$password_old_format = (!STRIP) ? addslashes($password_old_format) : $password_old_format;
		$password_new_format = $this->request->variable('password', '', true);

		if ($super_globals_disabled)
		{
			$this->request->disable_super_globals();
		}

		if ($password == $password_new_format)
		{
			if (!function_exists('utf8_to_cp1252'))
			{
				include($this->src_root_path . 'includes/utf/data/recode_basic.' . $this->php_ext);
			}

			if ($this->helper->string_compare(md5($password_old_format), $hash) || $this->helper->string_compare(md5(\utf8_to_cp1252($password_old_format)), $hash)
				|| $this->salted_md5->check(md5($password_old_format), $hash) === true
				|| $this->salted_md5->check(md5(\utf8_to_cp1252($password_old_format)), $hash) === true)
			{
				return true;
			}
		}

		return false;
	}
}
