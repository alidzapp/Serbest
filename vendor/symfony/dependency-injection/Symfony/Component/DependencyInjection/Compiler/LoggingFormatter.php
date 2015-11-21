<?php


namespace Symfony\Component\DependencyInjection\Compiler;

class LoggingFormatter
{
    public function formatRemoveService(CompilerPassInterface $pass, $id, $reason)
    {
        return $this->format($pass, sprintf('Removed service "%s"; reason: %s', $id, $reason));
    }

    public function formatInlineService(CompilerPassInterface $pass, $id, $target)
    {
        return $this->format($pass, sprintf('Inlined service "%s" to "%s".', $id, $target));
    }

    public function formatUpdateReference(CompilerPassInterface $pass, $serviceId, $oldDestId, $newDestId)
    {
        return $this->format($pass, sprintf('Changed reference of service "%s" previously pointing to "%s" to "%s".', $serviceId, $oldDestId, $newDestId));
    }

    public function formatResolveInheritance(CompilerPassInterface $pass, $childId, $parentId)
    {
        return $this->format($pass, sprintf('Resolving inheritance for "%s" (parent: %s).', $childId, $parentId));
    }

    public function format(CompilerPassInterface $pass, $message)
    {
        return sprintf('%s: %s', get_class($pass), $message);
    }
}