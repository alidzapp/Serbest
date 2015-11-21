<?php
/**
*
* This file is part of the src Forum Software package.
*
* @copyright (c) src Limited <https://www.src.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
* For full copyright and license information, please see
* the docs/CREDITS.txt file.
*
*/

namespace src\db;

use src\user;

class html_migrator_output_handler implements migrator_output_handler_interface
{
	/**
	 * User object.
	 *
	 * @var user
	 */
	private $user;

	/**
	 * Constructor
	 *
	 * @param user $user	User object
	 */
	public function __construct(user $user)
	{
		$this->user = $user;
	}

	/**
	 * {@inheritdoc}
	 */
	public function write($message, $verbosity)
	{
		if ($verbosity <= migrator_output_handler_interface::VERBOSITY_VERBOSE)
		{
			$final_message = call_user_func_array(array($this->user, 'lang'), $message);
			echo $final_message . "<br />\n";
		}
	}
}
