<?php

namespace Symfony\Component\Config\Resource;

interface ResourceInterface
{
    
    public function __toString();

    /**
     * Returns true if the resource has not been updated since the given timestamp.
     *
     * @param int     $timestamp The last time the resource was loaded
     *
     * @return bool    true if the resource has not been updated, false otherwise
     */
    public function isFresh($timestamp);

    /**
     * Returns the resource tied to this Resource.
     *
     * @return mixed The resource
     */
    public function getResource();
}
