<?php

/**
 * Represents a function template test.
*/
class Twig_Test_Function extends Twig_Test
{
    protected $function;

    public function __construct($function, array $options = array())
    {
        $options['callable'] = $function;

        parent::__construct($options);

        $this->function = $function;
    }

    public function compile()
    {
        return $this->function;
    }
}
