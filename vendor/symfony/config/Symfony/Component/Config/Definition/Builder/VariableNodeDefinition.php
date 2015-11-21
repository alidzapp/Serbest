<?php

namespace Symfony\Component\Config\Definition\Builder;

use Symfony\Component\Config\Definition\VariableNode;

class VariableNodeDefinition extends NodeDefinition
{
    /**
     * Instantiate a Node
     *
     * @return VariableNode The node
     */
    protected function instantiateNode()
    {
        return new VariableNode($this->name, $this->parent);
    }

    /**
     * {@inheritdoc}
     */
    protected function createNode()
    {
        $node = $this->instantiateNode();

        if (null !== $this->normalization) {
            $node->setNormalizationClosures($this->normalization->before);
        }

        if (null !== $this->merge) {
            $node->setAllowOverwrite($this->merge->allowOverwrite);
        }

        if (true === $this->default) {
            $node->setDefaultValue($this->defaultValue);
        }

        if (false === $this->allowEmptyValue) {
            $node->setAllowEmptyValue($this->allowEmptyValue);
        }

        $node->addEquivalentValue(null, $this->nullEquivalent);
        $node->addEquivalentValue(true, $this->trueEquivalent);
        $node->addEquivalentValue(false, $this->falseEquivalent);
        $node->setRequired($this->required);

        if (null !== $this->validation) {
            $node->setFinalValidationClosures($this->validation->rules);
        }

        return $node;
    }
}
