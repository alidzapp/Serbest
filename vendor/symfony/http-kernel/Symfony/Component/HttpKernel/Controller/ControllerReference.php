<?php

namespace Symfony\Component\HttpKernel\Controller;

class ControllerReference
{
    public $controller;
    public $attributes = array();
    public $query = array();

    /**
     * Constructor.
     *
     * @param string $controller The controller name
     * @param array  $attributes An array of parameters to add to the Request attributes
     * @param array  $query      An array of parameters to add to the Request query string
     */
    public function __construct($controller, array $attributes = array(), array $query = array())
    {
        $this->controller = $controller;
        $this->attributes = $attributes;
        $this->query = $query;
    }
}
