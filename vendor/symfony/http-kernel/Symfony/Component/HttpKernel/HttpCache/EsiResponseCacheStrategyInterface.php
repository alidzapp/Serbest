<?php


namespace Symfony\Component\HttpKernel\HttpCache;

use Symfony\Component\HttpFoundation\Response;


interface EsiResponseCacheStrategyInterface
{
    /**
     * Adds a Response.
     *
     * @param Response $response
     */
    public function add(Response $response);

    /**
     * Updates the Response HTTP headers based on the embedded Responses.
     *
     * @param Response $response
     */
    public function update(Response $response);
}
