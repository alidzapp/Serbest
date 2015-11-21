<?php


namespace src\di\pass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
* Appends an add method call to the definition of each collection service for
* the services tagged with the appropriate name defined in the collection's
* service_collection tag.
*/
class collection_pass implements CompilerPassInterface
{
	/**
	* Modify the container before it is passed to the rest of the code
	*
	* @param ContainerBuilder $container ContainerBuilder object
	* @return null
	*/
	public function process(ContainerBuilder $container)
	{
		foreach ($container->findTaggedServiceIds('service_collection') as $id => $data)
		{
			$definition = $container->getDefinition($id);

			foreach ($container->findTaggedServiceIds($data[0]['tag']) as $service_id => $service_data)
			{
				$definition->addMethodCall('add', array($service_id));
			}
		}
	}
}
