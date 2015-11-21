<?php

namespace Symfony\Component\Config\Definition\Builder;

use Symfony\Component\Config\Definition\IntegerNode;

class IntegerNodeDefinition extends NumericNodeDefinition
{
    /**
     * Instantiates a Node.
     *
     * @return IntegerNode The node
     */
    protected function instantiateNode()
    {
        return new IntegerNode($this->name, $this->parent, $this->min, $this->max);
    }
}
