<?php

namespace src\auth;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Collection of auth providers to be configured at container compile time.
*/
class provider_collection extends \src\di\service_collection
{
	/** @var \src\config\config src Config */
	protected $config;

	/**
	* Constructor
	*
	* @param ContainerInterface $container Container object
	* @param \src\config\config $config src config
	*/
	public function __construct(ContainerInterface $container, \src\config\config $config)
	{
		$this->container = $container;
		$this->config = $config;
	}

	/**
	* Get an auth provider.
	*
	* @param string $provider_name The name of the auth provider
	* @return object	Default auth provider selected in config if it
	*			does exist. Otherwise the standard db auth
	*			provider.
	* @throws \RuntimeException If neither the auth provider that
	*			is specified by the src config nor the db
	*			auth provider exist. The db auth provider
	*			should always exist in a src installation.
	*/
	public function get_provider($provider_name = '')
	{
		$provider_name = ($provider_name !== '') ? $provider_name : basename(trim($this->config['auth_method']));
		if ($this->offsetExists('auth.provider.' . $provider_name))
		{
			return $this->offsetGet('auth.provider.' . $provider_name);
		}
		// Revert to db auth provider if selected method does not exist
		else if ($this->offsetExists('auth.provider.db'))
		{
			return $this->offsetGet('auth.provider.db');
		}
		else
		{
			throw new \RuntimeException(sprintf('The authentication provider for the authentication method "%1$s" does not exist. It was not possible to recover from this by reverting to the database authentication provider.', $this->config['auth_method']));
		}
	}
}
