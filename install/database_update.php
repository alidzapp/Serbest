<?php

$update_start_time = time();

define('IN_src', true);
define('IN_INSTALL', true);
$src_root_path = (defined('src_ROOT_PATH')) ? src_ROOT_PATH : './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

function src_end_update($cache, $config)
{
	$cache->purge();

	$config->increment('assets_version', 1);

?>
								</p>
							</div>
						</div>
					<span class="corners-bottom"><span></span></span>
				</div>
			</div>
		</div>

		<div id="page-footer">
			<div class="copyright">
				Powered by SourceFlan
			</div>
		</div>
	</div>
</body>
</html>

<?php

	garbage_collection();
	exit_handler();
}

require($src_root_path . 'includes/startup.' . $phpEx);
require($src_root_path . 'src/class_loader.' . $phpEx);

$src_class_loader = new \src\class_loader('src\\', "{$src_root_path}src/", $phpEx);
$src_class_loader->register();

$src_config_php_file = new \src\config_php_file($src_root_path, $phpEx);
extract($src_config_php_file->get_all());

if (!defined('src_INSTALLED') || empty($dbms) || empty($acm_type))
{
	die("Please read: <a href='../docs/INSTALL.html'>INSTALL.html</a> before attempting to update.");
}

// In case $src_adm_relative_path is not set (in case of an update), use the default.
$src_adm_relative_path = (isset($src_adm_relative_path)) ? $src_adm_relative_path : 'adm/';
$src_admin_path = (defined('src_ADMIN_PATH')) ? src_ADMIN_PATH : $src_root_path . $src_adm_relative_path;

// Include files
require($src_root_path . 'includes/functions.' . $phpEx);
require($src_root_path . 'includes/functions_content.' . $phpEx);

require($src_root_path . 'includes/constants.' . $phpEx);
include($src_root_path . 'includes/utf/utf_normalizer.' . $phpEx);
require($src_root_path . 'includes/utf/utf_tools.' . $phpEx);

// Set PHP error handler to ours
set_error_handler(defined('src_MSG_HANDLER') ? src_MSG_HANDLER : 'msg_handler');

// Set up container (must be done here because extensions table may not exist)
$src_container_builder = new \src\di\container_builder($src_config_php_file, $src_root_path, $phpEx);
$src_container_builder->set_use_extensions(false);
$src_container_builder->set_use_kernel_pass(false);
$src_container_builder->set_dump_container(false);
$src_container = $src_container_builder->get_container();

// set up caching
$cache = $src_container->get('cache');

// Instantiate some basic classes
$src_dispatcher = $src_container->get('dispatcher');
$request	= $src_container->get('request');
$user		= $src_container->get('user');
$auth		= $src_container->get('auth');
$db			= $src_container->get('dbal.conn');
$src_log	= $src_container->get('log');

// make sure request_var uses this request instance
request_var('', 0, false, false, $request); // "dependency injection" for a function

// Grab global variables, re-cache if necessary
$config = $src_container->get('config');
set_config(null, null, null, $config);
set_config_count(null, null, null, $config);

if (!isset($config['version_update_from']))
{
	$config->set('version_update_from', $config['version']);
}

$orig_version = $config['version_update_from'];

$user->add_lang(array('common', 'acp/common', 'install', 'migrator'));

// Add own hook handler, if present. :o
if (file_exists($src_root_path . 'includes/hooks/index.' . $phpEx))
{
	require($src_root_path . 'includes/hooks/index.' . $phpEx);
	$src_hook = new src_hook(array('exit_handler', 'src_user_session_handler', 'append_sid', array('template', 'display')));

	$src_hook_finder = $src_container->get('hook_finder');
	foreach ($src_hook_finder->find() as $hook)
	{
		@include($src_root_path . 'includes/hooks/' . $hook . '.' . $phpEx);
	}
}
else
{
	$src_hook = false;
}

header('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html dir="<?php echo $user->lang['DIRECTION']; ?>" lang="<?php echo $user->lang['USER_LANG']; ?>">
<head>
<meta charset="utf-8">

<title><?php echo $user->lang['UPDATING_TO_LATEST_STABLE']; ?></title>

<link href="<?php echo htmlspecialchars($src_admin_path); ?>style/admin.css" rel="stylesheet" type="text/css" media="screen" />

</head>

<body>
	<div id="wrap">
		<div id="page-header">&nbsp;</div>

		<div id="page-body">
			<div id="acp">
				<div class="panel">
					<span class="corners-top"><span></span></span>
						<div id="content">
							<div id="main" class="install-body">

								<h1><?php echo $user->lang['UPDATING_TO_LATEST_STABLE']; ?></h1>

								<br />

								<p><?php echo $user->lang['DATABASE_TYPE']; ?> :: <strong><?php echo $db->get_sql_layer(); ?></strong><br />
								<?php echo $user->lang['PREVIOUS_VERSION']; ?> :: <strong><?php echo $config['version']; ?></strong><br />

<?php

define('IN_DB_UPDATE', true);

/**
* @todo mysql update?
*/

// End startup code

$migrator = $src_container->get('migrator');
$migrator->set_output_handler(new \src\db\log_wrapper_migrator_output_handler($user, new \src\db\html_migrator_output_handler($user), $src_root_path . 'store/migrations_' . time() . '.log'));

$migrator->create_migrations_table();

$src_extension_manager = $src_container->get('ext.manager');

$migrations = $src_extension_manager
	->get_finder()
	->core_path('src/db/migration/data/')
	->extension_directory('/migrations')
	->get_classes();

$migrator->set_migrations($migrations);

// What is a safe limit of execution time? Half the max execution time should be safe.
//  No more than 15 seconds so the user isn't sitting and waiting for a very long time
$src_ini = new \src\php\ini();
$safe_time_limit = min(15, ($src_ini->get_int('max_execution_time') / 2));

// While we're going to try limit this to half the max execution time,
//  we want to try and take additional measures to prevent hitting the
//  max execution time (if, say, one migration step takes much longer
//  than the max execution time)
@set_time_limit(0);

while (!$migrator->finished())
{
	try
	{
		$migrator->update();
	}
	catch (\src\db\migration\exception $e)
	{
		echo $e->getLocalisedMessage($user);

		src_end_update($cache, $config);
	}

	$state = array_merge(array(
			'migration_schema_done' => false,
			'migration_data_done'	=> false,
		),
		$migrator->last_run_migration['state']
	);

	// Are we approaching the time limit? If so we want to pause the update and continue after refreshing
	if ((time() - $update_start_time) >= $safe_time_limit)
	{
		echo '<br />' . $user->lang['DATABASE_UPDATE_NOT_COMPLETED'] . '<br /><br />';
		echo '<a href="' . append_sid($src_root_path . 'install/database_update.' . $phpEx, 'type=' . $request->variable('type', 0) . '&amp;language=' . $request->variable('language', 'en')) . '" class="button1">' . $user->lang['DATABASE_UPDATE_CONTINUE'] . '</a>';

		src_end_update($cache, $config);
	}
}

if ($orig_version != $config['version'])
{
	add_log('admin', 'LOG_UPDATE_DATABASE', $orig_version, $config['version']);
}

echo $user->lang['DATABASE_UPDATE_COMPLETE'] . '<br />';

if ($request->variable('type', 0))
{
	echo $user->lang['INLINE_UPDATE_SUCCESSFUL'] . '<br /><br />';
	echo '<a href="' . append_sid($src_root_path . 'install/index.' . $phpEx, 'mode=update&amp;sub=update_db&amp;language=' . $request->variable('language', 'en')) . '" class="button1">' . $user->lang['CONTINUE_UPDATE_NOW'] . '</a>';
}
else
{
	echo '<div class="errorbox">' . $user->lang['UPDATE_FILES_NOTICE'] . '</div>';
	echo $user->lang['COMPLETE_LOGIN_TO_srcRD'];
}

$config->delete('version_update_from');

src_end_update($cache, $config);
