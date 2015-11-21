<?php

namespace Symfony\Component\Config\Definition;

/**
 * This interface must be implemented by nodes which can be used as prototypes.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
interface PrototypeNodeInterface extends NodeInterface
{
    /**
     * Sets the name of the node.
     *
     * @param string $name The name of the node
     */
    public function setName($name);
}
