<?php


namespace Symfony\Component\DependencyInjection;

class Variable
{
    private $name;

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Converts the object to a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
