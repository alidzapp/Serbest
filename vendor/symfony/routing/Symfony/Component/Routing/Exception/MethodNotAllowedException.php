<?php


namespace Symfony\Component\Routing\Exception;

class MethodNotAllowedException extends \RuntimeException implements ExceptionInterface
{
    /**
     * @var array
     */
    protected $allowedMethods = array();

    public function __construct(array $allowedMethods, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->allowedMethods = array_map('strtoupper', $allowedMethods);

        parent::__construct($message, $code, $previous);
    }

    /**
     * Gets the allowed HTTP methods.
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return $this->allowedMethods;
    }
}
