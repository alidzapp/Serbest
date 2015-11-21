<?php

namespace Symfony\Component\DependencyInjection;

interface ScopeInterface
{
    /**
     * @api
     */
    public function getName();

    /**
     * @api
     */
    public function getParentName();
}
