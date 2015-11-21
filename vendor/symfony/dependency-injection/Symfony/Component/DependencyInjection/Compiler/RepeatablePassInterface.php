<?php


namespace Symfony\Component\DependencyInjection\Compiler;

interface RepeatablePassInterface extends CompilerPassInterface
{
    /**
     * Sets the RepeatedPass interface.
     *
     * @param RepeatedPass $repeatedPass
     */
    public function setRepeatedPass(RepeatedPass $repeatedPass);
}
