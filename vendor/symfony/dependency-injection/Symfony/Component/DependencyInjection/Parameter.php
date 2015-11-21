<?php

namespace Symfony\Component\DependencyInjection;

class Parameter
{
    private $id;

    /**
     * Constructor.
     *
     * @param string $id The parameter key
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * __toString.
     *
     * @return string The parameter key
     */
    public function __toString()
    {
        return (string) $this->id;
    }
}
