<?php

namespace Symfony\Component\DependencyInjection\Exception;

class InactiveScopeException extends RuntimeException
{
    private $serviceId;
    private $scope;

    public function __construct($serviceId, $scope, \Exception $previous = null)
    {
        parent::__construct(sprintf('You cannot create a service ("%s") of an inactive scope ("%s").', $serviceId, $scope), 0, $previous);

        $this->serviceId = $serviceId;
        $this->scope = $scope;
    }

    public function getServiceId()
    {
        return $this->serviceId;
    }

    public function getScope()
    {
        return $this->scope;
    }
}
