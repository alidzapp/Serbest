<?php

namespace Symfony\Component\Config\Definition\Builder;

use Symfony\Component\Config\Definition\ScalarNode;

class ScalarNodeDefinition extends VariableNodeDefinition
{
    /**
     * Instantiate a Node
     *
     * @return ScalarNode The node
     */
    protected function instantiateNode()
    {
        return new ScalarNode($this->name, $this->parent);
    }
}
