<?php


namespace Symfony\Component\HttpKernel\Exception;

class PreconditionRequiredHttpException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string     $message   The internal exception message
     * @param \Exception $previous  The previous exception
     * @param int        $code      The internal exception code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(428, $message, $previous, array(), $code);
    }
}
