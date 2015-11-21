<?php

namespace src\auth\provider\oauth\service;

/**
* Base OAuth abstract class that all OAuth services should implement
*/
abstract class base implements \src\auth\provider\oauth\service\service_interface
{
	/**
	* External OAuth service provider
	*
	* @var \OAuth\Common\Service\ServiceInterface
	*/
	protected $service_provider;

	/**
	* {@inheritdoc}
	*/
	public function get_external_service_provider()
	{
		return $this->service_provider;
	}

	/**
	* {@inheritdoc}
	*/
	public function get_auth_scope()
	{
		return array();
	}

	/**
	* {@inheritdoc}
	*/
	public function set_external_service_provider(\OAuth\Common\Service\ServiceInterface $service_provider)
	{
		$this->service_provider = $service_provider;
	}
}
