<?php

class Twig_Node_Expression_Binary_Mul extends Twig_Node_Expression_Binary
{
    public function operator(Twig_Compiler $compiler)
    {
        return $compiler->raw('*');
    }
}
