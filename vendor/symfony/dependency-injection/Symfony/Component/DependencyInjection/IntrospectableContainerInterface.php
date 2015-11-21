<?php

namespace Symfony\Component\DependencyInjection;

interface IntrospectableContainerInterface extends ContainerInterface
{
    /**
     * Check for whether or not a service has been initialized.
     *
     * @param string $id
     *
     * @return bool    true if the service has been initialized, false otherwise
     *
     */
    public function initialized($id);
}
