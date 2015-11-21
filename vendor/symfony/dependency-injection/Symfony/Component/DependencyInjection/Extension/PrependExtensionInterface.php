<?php


namespace Symfony\Component\DependencyInjection\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface PrependExtensionInterface
{

    public function prepend(ContainerBuilder $container);
}
