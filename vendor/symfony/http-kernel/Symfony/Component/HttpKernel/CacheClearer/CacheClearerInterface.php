<?php


namespace Symfony\Component\HttpKernel\CacheClearer;

interface CacheClearerInterface
{
    /**
     * Clears any caches necessary.
     *
     * @param string $cacheDir The cache directory.
     */
    public function clear($cacheDir);
}
