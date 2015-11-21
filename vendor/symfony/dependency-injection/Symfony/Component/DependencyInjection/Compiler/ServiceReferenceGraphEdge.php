<?php

namespace Symfony\Component\DependencyInjection\Compiler;

class ServiceReferenceGraphEdge
{
    private $sourceNode;
    private $destNode;
    private $value;

    /**
     * Constructor.
     *
     * @param ServiceReferenceGraphNode $sourceNode
     * @param ServiceReferenceGraphNode $destNode
     * @param string                    $value
     */
    public function __construct(ServiceReferenceGraphNode $sourceNode, ServiceReferenceGraphNode $destNode, $value = null)
    {
        $this->sourceNode = $sourceNode;
        $this->destNode = $destNode;
        $this->value = $value;
    }

    /**
     * Returns the value of the edge
     *
     * @return ServiceReferenceGraphNode
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns the source node
     *
     * @return ServiceReferenceGraphNode
     */
    public function getSourceNode()
    {
        return $this->sourceNode;
    }

    /**
     * Returns the destination node
     *
     * @return ServiceReferenceGraphNode
     */
    public function getDestNode()
    {
        return $this->destNode;
    }
}
