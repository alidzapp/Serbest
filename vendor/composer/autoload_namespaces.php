<?php

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Twig_' => array($vendorDir . '/twig/twig/lib'),
    'Symfony\\Component\\Yaml\\' => array($vendorDir . '/symfony/yaml'),
    'Symfony\\Component\\Routing\\' => array($vendorDir . '/symfony/routing'),
    'Symfony\\Component\\HttpKernel\\' => array($vendorDir . '/symfony/http-kernel'),
    'Symfony\\Component\\HttpFoundation\\' => array($vendorDir . '/symfony/http-foundation'),
    'Symfony\\Component\\Filesystem\\' => array($vendorDir . '/symfony/filesystem'),
    'Symfony\\Component\\EventDispatcher\\' => array($vendorDir . '/symfony/event-dispatcher'),
    'Symfony\\Component\\DependencyInjection\\' => array($vendorDir . '/symfony/dependency-injection'),
    'Symfony\\Component\\Debug\\' => array($vendorDir . '/symfony/debug'),
    'Symfony\\Component\\Console\\' => array($vendorDir . '/symfony/console'),
    'Symfony\\Component\\Config\\' => array($vendorDir . '/symfony/config'),
    'Psr\\Log\\' => array($vendorDir . '/psr/log'),
    'OAuth\\Unit' => array($vendorDir . '/lusitanian/oauth/tests'),
    'OAuth' => array($vendorDir . '/lusitanian/oauth/src'),
);
