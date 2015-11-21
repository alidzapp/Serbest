<?php


namespace Symfony\Component\Config\Definition\Builder;

class MergeBuilder
{
    protected $node;
    public $allowFalse;
    public $allowOverwrite;

    /**
     * Constructor
     *
     * @param NodeDefinition $node The related node
     */
    public function __construct(NodeDefinition $node)
    {
        $this->node = $node;
        $this->allowFalse = false;
        $this->allowOverwrite = true;
    }

    /**
     * Sets whether the node can be unset.
     *
     * @param bool    $allow
     *
     * @return MergeBuilder
     */
    public function allowUnset($allow = true)
    {
        $this->allowFalse = $allow;

        return $this;
    }

    /**
     * Sets whether the node can be overwritten.
     *
     * @param bool    $deny Whether the overwriting is forbidden or not
     *
     * @return MergeBuilder
     */
    public function denyOverwrite($deny = true)
    {
        $this->allowOverwrite = !$deny;

        return $this;
    }

    /**
     * Returns the related node.
     *
     * @return NodeDefinition
     */
    public function end()
    {
        return $this->node;
    }
}
