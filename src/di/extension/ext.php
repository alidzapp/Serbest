<?php
namespace src\di\extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
* Container ext extension
*/
class ext extends Extension
{
	protected $paths = array();

	public function __construct($enabled_extensions)
	{
		foreach ($enabled_extensions as $ext => $path)
		{
			$this->paths[] = $path;
		}
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
		foreach ($this->paths as $path)
		{
			if (file_exists($path . '/config/services.yml'))
			{
				$loader = new YamlFileLoader($container, new FileLocator(src_realpath($path . '/config')));
				$loader->load('services.yml');
			}
		}
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
		return 'ext';
	}
}
