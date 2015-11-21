<?php

namespace Symfony\Component\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class RemovePrivateAliasesPass implements CompilerPassInterface
{
    /**
     * Removes private aliases from the ContainerBuilder
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $compiler = $container->getCompiler();
        $formatter = $compiler->getLoggingFormatter();

        foreach ($container->getAliases() as $id => $alias) {
            if ($alias->isPublic()) {
                continue;
            }

            $container->removeAlias($id);
            $compiler->addLogMessage($formatter->formatRemoveService($this, $id, 'private alias'));
        }
    }
}
