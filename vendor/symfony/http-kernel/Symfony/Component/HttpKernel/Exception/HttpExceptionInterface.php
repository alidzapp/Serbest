<?php

namespace Symfony\Component\HttpKernel\Exception;

interface HttpExceptionInterface
{
    /**
     * Returns the status code.
     *
     * @return int     An HTTP response status code
     */
    public function getStatusCode();

    /**
     * Returns response headers.
     *
     * @return array Response headers
     */
    public function getHeaders();
}
