<?php


namespace Symfony\Component\Config\Definition;

use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

class IntegerNode extends NumericNode
{
    /**
     * {@inheritdoc}
     */
    protected function validateType($value)
    {
        if (!is_int($value)) {
            $ex = new InvalidTypeException(sprintf('Invalid type for path "%s". Expected int, but got %s.', $this->getPath(), gettype($value)));
            $ex->setPath($this->getPath());

            throw $ex;
        }
    }
}
