<?php


namespace Symfony\Component\Config\Definition\Builder;

class ValidationBuilder
{
    protected $node;
    public $rules;

    /**
     * Constructor
     *
     * @param NodeDefinition $node The related node
     */
    public function __construct(NodeDefinition $node)
    {
        $this->node = $node;

        $this->rules = array();
    }

    /**
     * Registers a closure to run as normalization or an expression builder to build it if null is provided.
     *
     * @param \Closure $closure
     *
     * @return ExprBuilder|ValidationBuilder
     */
    public function rule(\Closure $closure = null)
    {
        if (null !== $closure) {
            $this->rules[] = $closure;

            return $this;
        }

        return $this->rules[] = new ExprBuilder($this->node);
    }
}
