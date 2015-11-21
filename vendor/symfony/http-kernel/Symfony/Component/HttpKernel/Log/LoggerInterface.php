<?php

namespace Symfony\Component\HttpKernel\Log;

use Psr\Log\LoggerInterface as PsrLogger;

interface LoggerInterface extends PsrLogger
{
 
    public function emerg($message, array $context = array());

    /**
     * @api
     * @deprecated since 2.2, to be removed in 3.0. Use critical() which is PSR-3 compatible.
     */
    public function crit($message, array $context = array());

    /**
     * @api
     * @deprecated since 2.2, to be removed in 3.0. Use error() which is PSR-3 compatible.
     */
    public function err($message, array $context = array());

    /**
     * @api
     * @deprecated since 2.2, to be removed in 3.0. Use warning() which is PSR-3 compatible.
     */
    public function warn($message, array $context = array());
}
