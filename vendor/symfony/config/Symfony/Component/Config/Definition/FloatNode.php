<?php


namespace Symfony\Component\Config\Definition;

use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

class FloatNode extends NumericNode
{
    /**
     * {@inheritdoc}
     */
    protected function validateType($value)
    {
        // Integers are also accepted, we just cast them
        if (is_int($value)) {
            $value = (float) $value;
        }

        if (!is_float($value)) {
            $ex = new InvalidTypeException(sprintf('Invalid type for path "%s". Expected float, but got %s.', $this->getPath(), gettype($value)));
            $ex->setPath($this->getPath());

            throw $ex;
        }
    }
}
