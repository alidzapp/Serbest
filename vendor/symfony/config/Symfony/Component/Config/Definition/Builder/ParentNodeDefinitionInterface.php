<?php

namespace Symfony\Component\Config\Definition\Builder;

interface ParentNodeDefinitionInterface
{
    public function children();

    public function append(NodeDefinition $node);

    public function setBuilder(NodeBuilder $builder);
}
