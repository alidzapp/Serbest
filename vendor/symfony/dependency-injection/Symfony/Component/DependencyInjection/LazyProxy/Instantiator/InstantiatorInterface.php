<?php

namespace Symfony\Component\DependencyInjection\LazyProxy\Instantiator;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;

interface InstantiatorInterface
{
    /**
     * Instantiates a proxy object.
     *
     * @param ContainerInterface $container        the container from which the service is being requested
     * @param Definition         $definition       the definition of the requested service
     * @param string             $id               identifier of the requested service
     * @param callable           $realInstantiator zero-argument callback that is capable of producing the real
     *                                             service instance
     *
     * @return object
     */
    public function instantiateProxy(ContainerInterface $container, Definition $definition, $id, $realInstantiator);
}
