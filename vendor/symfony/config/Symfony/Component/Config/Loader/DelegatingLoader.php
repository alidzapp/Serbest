<?php

namespace Symfony\Component\Config\Loader;

use Symfony\Component\Config\Exception\FileLoaderLoadException;

class DelegatingLoader extends Loader
{
    /**
     * Constructor.
     *
     * @param LoaderResolverInterface $resolver A LoaderResolverInterface instance
     */
    public function __construct(LoaderResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Loads a resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return mixed
     *
     * @throws FileLoaderLoadException if no loader is found.
     */
    public function load($resource, $type = null)
    {
        if (false === $loader = $this->resolver->resolve($resource, $type)) {
            throw new FileLoaderLoadException($resource);
        }

        return $loader->load($resource, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return false !== $this->resolver->resolve($resource, $type);
    }
}
