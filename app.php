<?php

/**
* @ignore
*/
define('IN_src', true);
$src_root_path = (defined('src_ROOT_PATH')) ? src_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($src_root_path . 'common.' . $phpEx);
include($src_root_path . 'includes/functions_url_matcher.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('app');

$http_kernel = $src_container->get('http_kernel');
$symfony_request = $src_container->get('symfony_request');
$response = $http_kernel->handle($symfony_request);
$response->send();
$http_kernel->terminate($symfony_request, $response);
