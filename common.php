<?php


/**
* Minimum Requirement: PHP 5.3.3
*/

if (!defined('IN_src'))
{
	exit;
}

require($src_root_path . 'includes/startup.' . $phpEx);
require($src_root_path . 'src/class_loader.' . $phpEx);

$src_class_loader = new \src\class_loader('src\\', "{$src_root_path}src/", $phpEx);
$src_class_loader->register();

$src_config_php_file = new \src\config_php_file($src_root_path, $phpEx);
extract($src_config_php_file->get_all());

if (!defined('src_INSTALLED'))
{
	// Redirect the user to the installer
	require($src_root_path . 'includes/functions.' . $phpEx);

	// We have to generate a full HTTP/1.1 header here since we can't guarantee to have any of the information
	// available as used by the redirect function
	$server_name = (!empty($_SERVER['HTTP_HOST'])) ? strtolower($_SERVER['HTTP_HOST']) : ((!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : getenv('SERVER_NAME'));
	$server_port = (!empty($_SERVER['SERVER_PORT'])) ? (int) $_SERVER['SERVER_PORT'] : (int) getenv('SERVER_PORT');
	$secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1 : 0;

	$script_name = (!empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : getenv('PHP_SELF');
	if (!$script_name)
	{
		$script_name = (!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
	}

	// $src_root_path accounts for redirects from e.g. /adm
	$script_path = trim(dirname($script_name)) . '/' . $src_root_path . 'install/index.' . $phpEx;
	// Replace any number of consecutive backslashes and/or slashes with a single slash
	// (could happen on some proxy setups and/or Windows servers)
	$script_path = preg_replace('#[\\\\/]{2,}#', '/', $script_path);

	// Eliminate . and .. from the path
	require($src_root_path . 'src/filesystem.' . $phpEx);
	$src_filesystem = new src\filesystem();
	$script_path = $src_filesystem->clean_path($script_path);

	$url = (($secure) ? 'https://' : 'http://') . $server_name;

	if ($server_port && (($secure && $server_port <> 443) || (!$secure && $server_port <> 80)))
	{
		// HTTP HOST can carry a port number...
		if (strpos($server_name, ':') === false)
		{
			$url .= ':' . $server_port;
		}
	}

	$url .= $script_path;
	header('Location: ' . $url);
	exit;
}

// In case $src_adm_relative_path is not set (in case of an update), use the default.
$src_adm_relative_path = (isset($src_adm_relative_path)) ? $src_adm_relative_path : 'adm/';
$src_admin_path = (defined('src_ADMIN_PATH')) ? src_ADMIN_PATH : $src_root_path . $src_adm_relative_path;

// Include files
require($src_root_path . 'includes/functions.' . $phpEx);
require($src_root_path . 'includes/functions_content.' . $phpEx);
include($src_root_path . 'includes/functions_compatibility.' . $phpEx);

require($src_root_path . 'includes/constants.' . $phpEx);
require($src_root_path . 'includes/utf/utf_tools.' . $phpEx);

// Set PHP error handler to ours
set_error_handler(defined('src_MSG_HANDLER') ? src_MSG_HANDLER : 'msg_handler');

$src_class_loader_ext = new \src\class_loader('\\', "{$src_root_path}ext/", $phpEx);
$src_class_loader_ext->register();

src_load_extensions_autoloaders($src_root_path);

// Set up container
$src_container_builder = new \src\di\container_builder($src_config_php_file, $src_root_path, $phpEx);
$src_container = $src_container_builder->get_container();

$src_class_loader->set_cache($src_container->get('cache.driver'));
$src_class_loader_ext->set_cache($src_container->get('cache.driver'));

require($src_root_path . 'includes/compatibility_globals.' . $phpEx);

// Add own hook handler
require($src_root_path . 'includes/hooks/index.' . $phpEx);
$src_hook = new src_hook(array('exit_handler', 'src_user_session_handler', 'append_sid', array('template', 'display')));
$src_hook_finder = $src_container->get('hook_finder');

foreach ($src_hook_finder->find() as $hook)
{
	@include($src_root_path . 'includes/hooks/' . $hook . '.' . $phpEx);
}

/**
* Main event which is triggered on every page
*
* You can use this event to load function files and initiate objects
*
* NOTE:	At this point the global session ($user) and permissions ($auth)
*		do NOT exist yet. If you need to use the user object
*		(f.e. to include language files) or need to check permissions,
*		please use the core.user_setup event instead!
*
* @event core.common
* @since 3.1.0-a1
*/
$src_dispatcher->dispatch('core.common');
