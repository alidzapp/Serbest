<?php


namespace src;

use Symfony\Component\HttpFoundation\Request;

/**
 * WARNING: The Symfony request does not escape the input and should be used very carefully
 * prefer the src request as possible
 */
class symfony_request extends Request
{
	/**
	* Constructor
	*
	* @param \src\request\request_interface $src_request
	*/
	public function __construct(\src\request\request_interface $src_request)
	{
		$get_parameters = $src_request->get_super_global(\src\request\request_interface::GET);
		$post_parameters = $src_request->get_super_global(\src\request\request_interface::POST);
		$server_parameters = $src_request->get_super_global(\src\request\request_interface::SERVER);
		$files_parameters = $src_request->get_super_global(\src\request\request_interface::FILES);
		$cookie_parameters = $src_request->get_super_global(\src\request\request_interface::COOKIE);

		parent::__construct($get_parameters, $post_parameters, array(), $cookie_parameters, $files_parameters, $server_parameters);
	}
}
