<?php


namespace Symfony\Component\Console\Descriptor;

interface DescriptorInterface
{
    /**
     * Describes an InputArgument instance.
     *
     * @param object $object
     * @param array  $options
     *
     * @return string|mixed
     */
    public function describe($object, array $options = array());
}
