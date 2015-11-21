<?php

/**
* DO NOT CHANGE
*/
if (!defined('IN_src'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'CONFIG_NOT_EXIST'					=> 'The config setting "%s" unexpectedly does not exist.',

	'GROUP_NOT_EXIST'					=> 'The group "%s" unexpectedly does not exist.',

	'MIGRATION_APPLY_DEPENDENCIES'		=> 'Apply dependencies of %s.',
	'MIGRATION_DATA_DONE'				=> 'Installed Data: %1$s; Time: %2$.2f seconds',
	'MIGRATION_DATA_IN_PROGRESS'		=> 'Installing Data: %1$s; Time: %2$.2f seconds',
	'MIGRATION_DATA_RUNNING'			=> 'Installing Data: %s.',
	'MIGRATION_EFFECTIVELY_INSTALLED'	=> 'Migration already effectively installed (skipped): %s',
	'MIGRATION_EXCEPTION_ERROR'			=> 'Something went wrong during the request and an exception was thrown. The changes made before the error occurred were reversed to the best of our abilities, but you should check the site for errors.',
	'MIGRATION_NOT_FULFILLABLE'			=> 'The migration "%1$s" is not fulfillable, missing migration "%2$s".',
	'MIGRATION_NOT_VALID'				=> '%s is not a valid migration.',
	'MIGRATION_SCHEMA_DONE'				=> 'Installed Schema: %1$s; Time: %2$.2f seconds',
	'MIGRATION_SCHEMA_RUNNING'			=> 'Installing Schema: %s.',

	'MIGRATION_INVALID_DATA_MISSING_CONDITION'		=> 'A migration is invalid. An if statement helper is missing a condition.',
	'MIGRATION_INVALID_DATA_MISSING_STEP'			=> 'A migration is invalid. An if statement helper is missing a valid call to a migration step.',
	'MIGRATION_INVALID_DATA_CUSTOM_NOT_CALLABLE'	=> 'A migration is invalid. A custom callable function could not be called.',
	'MIGRATION_INVALID_DATA_UNKNOWN_TYPE'			=> 'A migration is invalid. An unknown migration tool type was encountered.',
	'MIGRATION_INVALID_DATA_UNDEFINED_TOOL'			=> 'A migration is invalid. An undefined migration tool was encountered.',
	'MIGRATION_INVALID_DATA_UNDEFINED_METHOD'		=> 'A migration is invalid. An undefined migration tool method was encountered.',

	'MODULE_ERROR'						=> 'An error occurred while creating a module: %s',
	'MODULE_INFO_FILE_NOT_EXIST'		=> 'A required module info file is missing: %2$s',
	'MODULE_NOT_EXIST'					=> 'A required module does not exist: %s',

	'PERMISSION_NOT_EXIST'				=> 'The permission setting "%s" unexpectedly does not exist.',

	'ROLE_NOT_EXIST'					=> 'The permission role "%s" unexpectedly does not exist.',
));
