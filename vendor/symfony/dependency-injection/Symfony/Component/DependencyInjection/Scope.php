<?php



namespace Symfony\Component\DependencyInjection;


class Scope implements ScopeInterface
{
    private $name;
    private $parentName;

    /**
     * @api
     */
    public function __construct($name, $parentName = ContainerInterface::SCOPE_CONTAINER)
    {
        $this->name = $name;
        $this->parentName = $parentName;
    }

    /**
     * @api
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @api
     */
    public function getParentName()
    {
        return $this->parentName;
    }
}
