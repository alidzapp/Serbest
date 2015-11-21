<?php

namespace Symfony\Component\Config\Definition;

use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

class ScalarNode extends VariableNode
{
    /**
     * {@inheritdoc}
     */
    protected function validateType($value)
    {
        if (!is_scalar($value) && null !== $value) {
            $ex = new InvalidTypeException(sprintf(
                'Invalid type for path "%s". Expected scalar, but got %s.',
                $this->getPath(),
                gettype($value)
            ));
            $ex->setPath($this->getPath());

            throw $ex;
        }
    }
}
