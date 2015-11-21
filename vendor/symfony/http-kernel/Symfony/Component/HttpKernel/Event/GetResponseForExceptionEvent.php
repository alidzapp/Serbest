<?php


namespace Symfony\Component\HttpKernel\Event;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;


class GetResponseForExceptionEvent extends GetResponseEvent
{
    /**
     * The exception object
     * @var \Exception
     */
    private $exception;

    public function __construct(HttpKernelInterface $kernel, Request $request, $requestType, \Exception $e)
    {
        parent::__construct($kernel, $request, $requestType);

        $this->setException($e);
    }

    /**
     * Returns the thrown exception
     *
     * @return \Exception  The thrown exception
     *
     * @api
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Replaces the thrown exception
     *
     * This exception will be thrown if no response is set in the event.
     *
     * @param \Exception $exception The thrown exception
     *
     * @api
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }
}
