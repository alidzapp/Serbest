<?php


namespace Symfony\Component\HttpKernel\Event;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PostResponseEvent extends Event
{
    /**
     * The kernel in which this event was thrown
     * @var HttpKernelInterface
     */
    private $kernel;

    private $request;

    private $response;

    public function __construct(HttpKernelInterface $kernel, Request $request, Response $response)
    {
        $this->kernel = $kernel;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Returns the kernel in which this event was thrown.
     *
     * @return HttpKernelInterface
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Returns the request for which this event was thrown.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Returns the response for which this event was thrown.
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}