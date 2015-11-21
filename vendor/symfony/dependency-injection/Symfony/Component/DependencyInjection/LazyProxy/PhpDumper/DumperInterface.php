<?php

namespace Symfony\Component\DependencyInjection\LazyProxy\PhpDumper;

use Symfony\Component\DependencyInjection\Definition;

interface DumperInterface
{
    /**
     * Inspects whether the given definitions should produce proxy instantiation logic in the dumped container.
     *
     * @param Definition $definition
     *
     * @return bool
     */
    public function isProxyCandidate(Definition $definition);

    /**
     * Generates the code to be used to instantiate a proxy in the dumped factory code.
     *
     * @param Definition $definition
     * @param string     $id         service identifier
     *
     * @return string
     */
    public function getProxyFactoryCode(Definition $definition, $id);

    /**
     * Generates the code for the lazy proxy.
     *
     * @param Definition $definition
     *
     * @return string
     */
    public function getProxyCode(Definition $definition);
}
