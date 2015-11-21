<?php

namespace Symfony\Component\Config\Exception;

class FileLoaderImportCircularReferenceException extends FileLoaderLoadException
{
    public function __construct(array $resources, $code = null, $previous = null)
    {
        $message = sprintf('Circular reference detected in "%s" ("%s" > "%s").', $this->varToString($resources[0]), implode('" > "', $resources), $resources[0]);

        call_user_func('Exception::__construct', $message, $code, $previous);
    }
}
