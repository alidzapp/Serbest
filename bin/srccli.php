#!/usr/bin/env php
<?php

use Symfony\Component\Console\Input\ArgvInput;

if (php_sapi_name() != 'cli')
{
	echo 'This program must be run from the command line.' . PHP_EOL;
	exit(1);
}

define('IN_src', true);
$src_root_path = __DIR__ . '/../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
require($src_root_path . 'includes/startup.' . $phpEx);
require($src_root_path . 'src/class_loader.' . $phpEx);

$src_class_loader = new \src\class_loader('src\\', "{$src_root_path}src/", $phpEx);
$src_class_loader->register();

$src_config_php_file = new \src\config_php_file($src_root_path, $phpEx);
extract($src_config_php_file->get_all());

require($src_root_path . 'includes/constants.' . $phpEx);
require($src_root_path . 'includes/functions.' . $phpEx);
require($src_root_path . 'includes/functions_admin.' . $phpEx);
require($src_root_path . 'includes/utf/utf_tools.' . $phpEx);

$src_container_builder = new \src\di\container_builder($src_config_php_file, $src_root_path, $phpEx);
$src_container_builder->set_dump_container(false);

$input = new ArgvInput();

if ($input->hasParameterOption(array('--safe-mode')))
{
	$src_container_builder->set_use_extensions(false);
	$src_container_builder->set_dump_container(false);
}
else
{
	$src_class_loader_ext = new \src\class_loader('\\', "{$src_root_path}ext/", $phpEx);
	$src_class_loader_ext->register();
	src_load_extensions_autoloaders($src_root_path);
}

$src_container = $src_container_builder->get_container();
$src_container->get('request')->enable_super_globals();
require($src_root_path . 'includes/compatibility_globals.' . $phpEx);

$user = $src_container->get('user');
$user->add_lang('acp/common');
$user->add_lang('cli');

$application = new \src\console\application('src Console', src_VERSION, $user);
$application->register_container_commands($src_container->get('console.command_collection'));
$application->run($input);
