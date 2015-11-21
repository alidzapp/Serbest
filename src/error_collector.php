<?php

namespace src;

class error_collector
{
	var $errors;
	var $error_types;

	/**
	 * Constructor.
	 *
	 * The variable $error_types may be set to a mask of PHP error types that
	 * the collector should keep, e.g. `E_ALL`. If unset, the current value of
	 * the error_reporting() function will be used to determine which errors
	 * the collector will keep.
	 *
	 * @see src3-13306
	 * @param int|null $error_types
	 */
	function __construct($error_types = null)
	{
		$this->errors = array();
		$this->error_types = $error_types;
	}

	function install()
	{
		set_error_handler(array(&$this, 'error_handler'), ($this->error_types !== null) ? $this->error_types : error_reporting());
	}

	function uninstall()
	{
		restore_error_handler();
	}

	function error_handler($errno, $msg_text, $errfile, $errline)
	{
		$this->errors[] = array($errno, $msg_text, $errfile, $errline);
	}

	function format_errors()
	{
		$text = '';
		foreach ($this->errors as $error)
		{
			if (!empty($text))
			{
				$text .= "<br />\n";
			}

			list($errno, $msg_text, $errfile, $errline) = $error;

			// Prevent leakage of local path to src install
			$errfile = src_filter_root_path($errfile);

			$text .= "Errno $errno: $msg_text at $errfile line $errline";
		}

		return $text;
	}
}
