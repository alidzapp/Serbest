<?php

namespace Symfony\Component\Config\Definition\Builder;

use Symfony\Component\Config\Definition\FloatNode;

class FloatNodeDefinition extends NumericNodeDefinition
{
    /**
     * Instantiates a Node.
     *
     * @return FloatNode The node
     */
    protected function instantiateNode()
    {
        return new FloatNode($this->name, $this->parent, $this->min, $this->max);
    }
}
