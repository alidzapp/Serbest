<?php

namespace Symfony\Component\Config\Loader;

interface LoaderResolverInterface
{
    /**
     * Returns a loader able to load the resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return LoaderInterface A LoaderInterface instance
     */
    public function resolve($resource, $type = null);
}
