<?php

namespace src\auth\provider\oauth\service;

/**
* OAuth service interface
*/
interface service_interface
{
	/**
	* Returns an array of the scopes necessary for auth
	*
	* @return	array	An array of the required scopes
	*/
	public function get_auth_scope();

	/**
	* Returns the external library service provider once it has been set
	*
	* @param	\OAuth\Common\Service\ServiceInterface|null
	*/
	public function get_external_service_provider();

	/**
	* Returns an array containing the service credentials belonging to requested
	* service.
	*
	* @return	array	An array containing the 'key' and the 'secret' of the
	*					service in the form:
	*						array(
	*							'key'		=> string
	*							'secret'	=> string
	*						)
	*/
	public function get_service_credentials();

	/**
	* Returns the results of the authentication in json format
	*
	* @throws	\src\auth\provider\oauth\service\exception
	* @return	string	The unique identifier returned by the service provider
	*					that is used to authenticate the user with src.
	*/
	public function perform_auth_login();

	/**
	* Returns the results of the authentication in json format
	* Use this function when the user already has an access token
	*
	* @throws	\src\auth\provider\oauth\service\exception
	* @return	string	The unique identifier returned by the service provider
	*					that is used to authenticate the user with src.
	*/
	public function perform_token_auth();

	/**
	* Sets the external library service provider
	*
	* @param	\OAuth\Common\Service\ServiceInterface	$service_provider
	*/
	public function set_external_service_provider(\OAuth\Common\Service\ServiceInterface $service_provider);
}