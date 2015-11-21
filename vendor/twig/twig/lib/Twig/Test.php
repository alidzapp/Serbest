<?php


abstract class Twig_Test implements Twig_TestInterface, Twig_TestCallableInterface
{
    protected $options;
    protected $arguments = array();

    public function __construct(array $options = array())
    {
        $this->options = array_merge(array(
            'callable' => null,
        ), $options);
    }

    public function getCallable()
    {
        return $this->options['callable'];
    }
}
