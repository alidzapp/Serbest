<?php

/**
*/
if (!defined('IN_src'))
{
	exit;
}

// set up caching
$cache = $src_container->get('cache');

// Instantiate some basic classes
$src_dispatcher = $src_container->get('dispatcher');
$request	= $src_container->get('request');
$user		= $src_container->get('user');
$auth		= $src_container->get('auth');
$db			= $src_container->get('dbal.conn');

// make sure request_var uses this request instance
request_var('', 0, false, false, $request); // "dependency injection" for a function

// Grab global variables, re-cache if necessary
$config = $src_container->get('config');
set_config(null, null, null, $config);
set_config_count(null, null, null, $config);

$src_log = $src_container->get('log');
$symfony_request = $src_container->get('symfony_request');
$src_filesystem = $src_container->get('filesystem');
$src_path_helper = $src_container->get('path_helper');

// load extensions
$src_extension_manager = $src_container->get('ext.manager');

$template = $src_container->get('template');
