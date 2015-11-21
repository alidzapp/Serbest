<?php


namespace Symfony\Component\DependencyInjection\Dumper;

interface DumperInterface
{
    /**
     * Dumps the service container.
     *
     * @param array $options An array of options
     *
     * @return string The representation of the service container
     *
     * @api
     */
    public function dump(array $options = array());
}
