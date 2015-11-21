<?php

if (!defined('IN_src'))
{
	exit;
}

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}


$lang = array_merge($lang, array(
	'EXTENSION'					=> 'Extension',
	'EXTENSIONS'				=> 'Extensions',
	'EXTENSIONS_ADMIN'			=> 'Extensions Manager',
	'EXTENSIONS_EXPLAIN'		=> 'The Extensions Manager allows you to manage all of your extensions statuses and view information about them.',
	'EXTENSION_INVALID_LIST'	=> 'The extension is not valid.<br />%s<br /><br />',
	'EXTENSION_NOT_AVAILABLE'	=> 'The selected extension is not available, please verify.',
	'EXTENSION_DIR_INVALID'		=> 'The selected extension has an invalid directory structure and cannot be enabled.',
	'EXTENSION_NOT_ENABLEABLE'	=> 'The selected extension cannot be enabled, please verify the extension’s requirements.',

	'DETAILS'				=> 'Details',

	'EXTENSIONS_DISABLED'	=> 'Disabled Extensions',
	'EXTENSIONS_ENABLED'	=> 'Enabled Extensions',

	'EXTENSION_DELETE_DATA'	=> 'Delete data',
	'EXTENSION_DISABLE'		=> 'Disable',
	'EXTENSION_ENABLE'		=> 'Enable',

	'EXTENSION_DELETE_DATA_EXPLAIN'	=> 'Deleting an extension’s data removes all of its data and settings. The extension files are retained so it can be enabled again.',
	'EXTENSION_DISABLE_EXPLAIN'		=> 'Disabling an extension retains its files, data and settings but removes any functionality added by the extension.',
	'EXTENSION_ENABLE_EXPLAIN'		=> 'Enabling an extension allows you to use it on your site.',

	'EXTENSION_DELETE_DATA_IN_PROGRESS'	=> 'The extension’s data is currently being deleted. Please do not leave or refresh this page until it is completed.',
	'EXTENSION_DISABLE_IN_PROGRESS'	=> 'The extension is currently being disabled. Please do not leave or refresh this page until it is completed.',
	'EXTENSION_ENABLE_IN_PROGRESS'	=> 'The extension is currently being enabled. Please do not leave or refresh this page until it is completed.',

	'EXTENSION_DELETE_DATA_SUCCESS'	=> 'The extension’s data was deleted successfully',
	'EXTENSION_DISABLE_SUCCESS'		=> 'The extension was disabled successfully',
	'EXTENSION_ENABLE_SUCCESS'		=> 'The extension was enabled successfully',

	'EXTENSION_NAME'			=> 'Extension Name',
	'EXTENSION_ACTIONS'			=> 'Actions',
	'EXTENSION_OPTIONS'			=> 'Options',
	'EXTENSION_UPDATE_HEADLINE'	=> 'Updating an extension',
	'EXTENSION_UPDATE_EXPLAIN'	=> '',
	'EXTENSION_REMOVE_HEADLINE'	=> 'Completely removing an extension from your site',
	'EXTENSION_REMOVE_EXPLAIN'	=> '',

	'EXTENSION_DELETE_DATA_CONFIRM'	=> 'Are you sure that you wish to delete the data associated with “%s”?<br /><br />This removes all of its data and settings and cannot be undone!',
	'EXTENSION_DISABLE_CONFIRM'		=> 'Are you sure that you wish to disable the “%s” extension?',
	'EXTENSION_ENABLE_CONFIRM'		=> 'Are you sure that you wish to enable the “%s” extension?',
	'EXTENSION_FORCE_UNSTABLE_CONFIRM'	=> 'Are you sure that you wish to force the use of unstable version?',

	'RETURN_TO_EXTENSION_LIST'	=> 'Return to the extension list',

	'EXT_DETAILS'			=> 'Extension Details',
	'DISPLAY_NAME'			=> 'Display Name',
	'CLEAN_NAME'			=> 'Clean Name',
	'TYPE'					=> 'Type',
	'DESCRIPTION'			=> 'Description',
	'VERSION'				=> 'Version',
	'HOMEPAGE'				=> 'Homepage',
	'PATH'					=> 'File Path',
	'TIME'					=> 'Release Time',
	'LICENSE'				=> 'Licence',

	'REQUIREMENTS'			=> 'Requirements',
	'src_VERSION'			=> 'src Version',
	'PHP_VERSION'			=> 'PHP Version',
	'AUTHOR_INFORMATION'	=> 'Author Information',
	'AUTHOR_NAME'			=> 'Name',
	'AUTHOR_EMAIL'			=> 'Email',
	'AUTHOR_HOMEPAGE'		=> 'Homepage',
	'AUTHOR_ROLE'			=> 'Role',

	'NOT_UP_TO_DATE'		=> '%s is not up to date',
	'UP_TO_DATE'			=> '%s is up to date',
	'ANNOUNCEMENT_TOPIC'	=> 'Release Announcement',
	'DOWNLOAD_LATEST'		=> 'Download Version',
	'NO_VERSIONCHECK'		=> 'No version check information given.',

	'VERSIONCHECK_FORCE_UPDATE_ALL'		=> '',
	'FORCE_UNSTABLE'					=> 'Always check for unstable versions',
	'EXTENSIONS_VERSION_CHECK_SETTINGS'	=> 'Version check settings',

	'META_FIELD_NOT_SET'	=> 'Required meta field %s has not been set.',
	'META_FIELD_INVALID'	=> 'Meta field %s is invalid.',
));
