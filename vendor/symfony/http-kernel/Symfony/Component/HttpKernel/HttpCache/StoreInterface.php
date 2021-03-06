<?php

namespace Symfony\Component\HttpKernel\HttpCache;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface StoreInterface
{
    /**
     * Locates a cached Response for the Request provided.
     *
     * @param Request $request A Request instance
     *
     * @return Response|null A Response instance, or null if no cache entry was found
     */
    public function lookup(Request $request);

    /**
     * Writes a cache entry to the store for the given Request and Response.
     *
     * Existing entries are read and any that match the response are removed. This
     * method calls write with the new list of cache entries.
     *
     * @param Request  $request  A Request instance
     * @param Response $response A Response instance
     *
     * @return string The key under which the response is stored
     */
    public function write(Request $request, Response $response);

    /**
     * Invalidates all cache entries that match the request.
     *
     * @param Request $request A Request instance
     */
    public function invalidate(Request $request);

    /**
     * Locks the cache for a given Request.
     *
     * @param Request $request A Request instance
     *
     * @return bool|string    true if the lock is acquired, the path to the current lock otherwise
     */
    public function lock(Request $request);

    /**
     * Releases the lock for the given Request.
     *
     * @param Request $request A Request instance
     *
     * @return bool    False if the lock file does not exist or cannot be unlocked, true otherwise
     */
    public function unlock(Request $request);

    /**
     * Returns whether or not a lock exists.
     *
     * @param Request $request A Request instance
     *
     * @return bool    true if lock exists, false otherwise
     */
    public function isLocked(Request $request);

    /**
     * Purges data for the given URL.
     *
     * @param string $url A URL
     *
     * @return bool    true if the URL exists and has been purged, false otherwise
     */
    public function purge($url);

    /**
     * Cleanups storage.
     */
    public function cleanup();
}
