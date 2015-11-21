<?php

namespace src\di\extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
* Container core extension
*/
class core extends Extension
{
	/**
	* Config path
	* @var string
	*/
	protected $config_path;

	/**
	* Constructor
	*
	* @param string $config_path Config path
	*/
	public function __construct($config_path)
	{
		$this->config_path = $config_path;
	}

	/**
	* Loads a specific configuration.
	*
	* @param array            $config    An array of configuration values
	* @param ContainerBuilder $container A ContainerBuilder instance
	*
	* @throws \InvalidArgumentException When provided tag is not defined in this extension
	*/
	public function load(array $config, ContainerBuilder $container)
	{
		$loader = new YamlFileLoader($container, new FileLocator(src_realpath($this->config_path)));
		$loader->load('services.yml');
	}

	/**
	* Returns the recommended alias to use in XML.
	*
	* This alias is also the mandatory prefix to use when using YAML.
	*
	* @return string The alias
	*/
	public function getAlias()
	{
		return 'core';
	}
}
