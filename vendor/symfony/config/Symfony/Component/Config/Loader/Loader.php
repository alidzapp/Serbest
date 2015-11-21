<?php

namespace Symfony\Component\Config\Loader;

use Symfony\Component\Config\Exception\FileLoaderLoadException;

abstract class Loader implements LoaderInterface
{
    protected $resolver;

    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * Sets the loader resolver.
     *
     * @param LoaderResolverInterface $resolver A LoaderResolverInterface instance
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Imports a resource.
     *
     * @param mixed  $resource A Resource
     * @param string $type     The resource type
     *
     * @return mixed
     */
    public function import($resource, $type = null)
    {
        return $this->resolve($resource, $type)->load($resource, $type);
    }

    /**
     * Finds a loader able to load an imported resource.
     *
     * @param mixed  $resource A Resource
     * @param string $type     The resource type
     *
     * @return LoaderInterface A LoaderInterface instance
     *
     * @throws FileLoaderLoadException if no loader is found
     */
    public function resolve($resource, $type = null)
    {
        if ($this->supports($resource, $type)) {
            return $this;
        }

        $loader = null === $this->resolver ? false : $this->resolver->resolve($resource, $type);

        if (false === $loader) {
            throw new FileLoaderLoadException($resource);
        }

        return $loader;
    }
}
