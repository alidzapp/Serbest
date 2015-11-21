<?php
namespace Symfony\Component\DependencyInjection\Exception;

class ServiceNotFoundException extends InvalidArgumentException
{
    private $id;
    private $sourceId;

    public function __construct($id, $sourceId = null, \Exception $previous = null, array $alternatives = array())
    {
        if (null === $sourceId) {
            $msg = sprintf('You have requested a non-existent service "%s".', $id);
        } else {
            $msg = sprintf('The service "%s" has a dependency on a non-existent service "%s".', $sourceId, $id);
        }

        if ($alternatives) {
            if (1 == count($alternatives)) {
                $msg .= ' Did you mean this: "';
            } else {
                $msg .= ' Did you mean one of these: "';
            }
            $msg .= implode('", "', $alternatives).'"?';
        }

        parent::__construct($msg, 0, $previous);

        $this->id = $id;
        $this->sourceId = $sourceId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSourceId()
    {
        return $this->sourceId;
    }
}
