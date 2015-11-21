<?php


namespace Symfony\Component\DependencyInjection\Dumper;

use Symfony\Component\DependencyInjection\ContainerBuilder;


abstract class Dumper implements DumperInterface
{
    protected $container;

    /**
     * Constructor.
     *
     * @param ContainerBuilder $container The service container to dump
     *
     * @api
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }
}
