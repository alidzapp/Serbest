<?php


namespace Symfony\Component\Config\Definition;

use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

/**
 * This node represents a Boolean value in the config tree.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class BooleanNode extends ScalarNode
{
    /**
     * {@inheritdoc}
     */
    protected function validateType($value)
    {
        if (!is_bool($value)) {
            $ex = new InvalidTypeException(sprintf(
                'Invalid type for path "%s". Expected boolean, but got %s.',
                $this->getPath(),
                gettype($value)
            ));
            $ex->setPath($this->getPath());

            throw $ex;
        }
    }
}
