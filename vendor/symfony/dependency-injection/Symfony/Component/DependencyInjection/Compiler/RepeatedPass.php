<?php


namespace Symfony\Component\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class RepeatedPass implements CompilerPassInterface
{
    /**
     * @var bool
     */
    private $repeat = false;

    /**
     * @var RepeatablePassInterface[]
     */
    private $passes;

    /**
     * Constructor.
     *
     * @param RepeatablePassInterface[] $passes An array of RepeatablePassInterface objects
     *
     * @throws InvalidArgumentException when the passes don't implement RepeatablePassInterface
     */
    public function __construct(array $passes)
    {
        foreach ($passes as $pass) {
            if (!$pass instanceof RepeatablePassInterface) {
                throw new InvalidArgumentException('$passes must be an array of RepeatablePassInterface.');
            }

            $pass->setRepeatedPass($this);
        }

        $this->passes = $passes;
    }

    /**
     * Process the repeatable passes that run more than once.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->repeat = false;
        foreach ($this->passes as $pass) {
            $pass->process($container);
        }

        if ($this->repeat) {
            $this->process($container);
        }
    }

    /**
     * Sets if the pass should repeat
     */
    public function setRepeat()
    {
        $this->repeat = true;
    }

    /**
     * Returns the passes
     *
     * @return RepeatablePassInterface[] An array of RepeatablePassInterface objects
     */
    public function getPasses()
    {
        return $this->passes;
    }
}
