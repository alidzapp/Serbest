<?php

class Twig_Node_AutoEscape extends Twig_Node
{
    public function __construct($value, Twig_NodeInterface $body, $lineno, $tag = 'autoescape')
    {
        parent::__construct(array('body' => $body), array('value' => $value), $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param Twig_Compiler A Twig_Compiler instance
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->subcompile($this->getNode('body'));
    }
}
