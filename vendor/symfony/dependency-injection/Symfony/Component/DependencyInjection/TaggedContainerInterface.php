<?php


namespace Symfony\Component\DependencyInjection;

interface TaggedContainerInterface extends ContainerInterface
{
    /**
     * Returns service ids for a given tag.
     *
     * @param string $name The tag name
     *
     * @return array An array of tags
     *
     * @api
     */
    public function findTaggedServiceIds($name);
}
