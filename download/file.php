<?php
/**
* @ignore
*/
define('IN_src', true);
$src_root_path = (defined('src_ROOT_PATH')) ? src_ROOT_PATH : './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

if (isset($_SERVER['CONTENT_TYPE']))
{
	if ($_SERVER['CONTENT_TYPE'] === 'application/x-java-archive')
	{
		exit;
	}
}
else if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Java') !== false)
{
	exit;
}

if (isset($_GET['avatar']))
{
	require($src_root_path . 'includes/startup.' . $phpEx);

	require($src_root_path . 'src/class_loader.' . $phpEx);
	$src_class_loader = new \src\class_loader('src\\', "{$src_root_path}src/", $phpEx);
	$src_class_loader->register();

	$src_config_php_file = new \src\config_php_file($src_root_path, $phpEx);
	extract($src_config_php_file->get_all());

	if (!defined('src_INSTALLED') || empty($dbms) || empty($acm_type))
	{
		exit;
	}

	require($src_root_path . 'includes/constants.' . $phpEx);
	require($src_root_path . 'includes/functions.' . $phpEx);
	require($src_root_path . 'includes/functions_download' . '.' . $phpEx);
	require($src_root_path . 'includes/utf/utf_tools.' . $phpEx);

	// Setup class loader first
	$src_class_loader_ext = new \src\class_loader('\\', "{$src_root_path}ext/", $phpEx);
	$src_class_loader_ext->register();

	src_load_extensions_autoloaders($src_root_path);

	// Set up container
	$src_container_builder = new \src\di\container_builder($src_config_php_file, $src_root_path, $phpEx);
	$src_container = $src_container_builder->get_container();

	$src_class_loader->set_cache($src_container->get('cache.driver'));
	$src_class_loader_ext->set_cache($src_container->get('cache.driver'));

	// set up caching
	$cache = $src_container->get('cache');

	$src_dispatcher = $src_container->get('dispatcher');
	$request	= $src_container->get('request');
	$db			= $src_container->get('dbal.conn');
	$src_log	= $src_container->get('log');

	unset($dbpasswd);

	request_var('', 0, false, false, $request);

	$config = $src_container->get('config');
	set_config(null, null, null, $config);
	set_config_count(null, null, null, $config);

	// load extensions
	$src_extension_manager = $src_container->get('ext.manager');

	// worst-case default
	$browser = strtolower($request->header('User-Agent', 'msie 6.0'));

	$src_avatar_manager = $src_container->get('avatar.manager');

	$filename = request_var('avatar', '');
	$avatar_group = false;
	$exit = false;

	if (isset($filename[0]) && $filename[0] === 'g')
	{
		$avatar_group = true;
		$filename = substr($filename, 1);
	}

	// '==' is not a bug - . as the first char is as bad as no dot at all
	if (strpos($filename, '.') == false)
	{
		send_status_line(403, 'Forbidden');
		$exit = true;
	}

	if (!$exit)
	{
		$ext		= substr(strrchr($filename, '.'), 1);
		$stamp		= (int) substr(stristr($filename, '_'), 1);
		$filename	= (int) $filename;
		$exit = set_modified_headers($stamp, $browser);
	}
	if (!$exit && !in_array($ext, array('png', 'gif', 'jpg', 'jpeg')))
	{
		// no way such an avatar could exist. They are not following the rules, stop the show.
		send_status_line(403, 'Forbidden');
		$exit = true;
	}


	if (!$exit)
	{
		if (!$filename)
		{
			// no way such an avatar could exist. They are not following the rules, stop the show.
			send_status_line(403, 'Forbidden');
		}
		else
		{
			send_avatar_to_browser(($avatar_group ? 'g' : '') . $filename . '.' . $ext, $browser);
		}
	}
	file_gc();
}

// implicit else: we are not in avatar mode
include($src_root_path . 'common.' . $phpEx);
require($src_root_path . 'includes/functions_download' . '.' . $phpEx);

$attach_id = request_var('id', 0);
$mode = request_var('mode', '');
$thumbnail = request_var('t', false);

// Start session management, do not update session page.
$user->session_begin(false);
$auth->acl($user->data);
$user->setup('viewtopic');

if (!$config['allow_attachments'] && !$config['allow_pm_attach'])
{
	send_status_line(404, 'Not Found');
	trigger_error('ATTACHMENT_FUNCTIONALITY_DISABLED');
}

if (!$attach_id)
{
	send_status_line(404, 'Not Found');
	trigger_error('NO_ATTACHMENT_SELECTED');
}

$sql = 'SELECT attach_id, post_msg_id, topic_id, in_message, poster_id, is_orphan, physical_filename, real_filename, extension, mimetype, filesize, filetime
	FROM ' . ATTACHMENTS_TABLE . "
	WHERE attach_id = $attach_id";
$result = $db->sql_query($sql);
$attachment = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if (!$attachment)
{
	send_status_line(404, 'Not Found');
	trigger_error('ERROR_NO_ATTACHMENT');
}
else if (!download_allowed())
{
	send_status_line(403, 'Forbidden');
	trigger_error($user->lang['LINKAGE_FORBIDDEN']);
}
else
{
	$attachment['physical_filename'] = utf8_basename($attachment['physical_filename']);

	if (!$attachment['in_message'] && !$config['allow_attachments'] || $attachment['in_message'] && !$config['allow_pm_attach'])
	{
		send_status_line(404, 'Not Found');
		trigger_error('ATTACHMENT_FUNCTIONALITY_DISABLED');
	}

	if ($attachment['is_orphan'])
	{
		// We allow admins having attachment permissions to see orphan attachments...
		$own_attachment = ($auth->acl_get('a_attach') || $attachment['poster_id'] == $user->data['user_id']) ? true : false;

		if (!$own_attachment || ($attachment['in_message'] && !$auth->acl_get('u_pm_download')) || (!$attachment['in_message'] && !$auth->acl_get('u_download')))
		{
			send_status_line(404, 'Not Found');
			trigger_error('ERROR_NO_ATTACHMENT');
		}

		// Obtain all extensions...
		$extensions = $cache->obtain_attach_extensions(true);
	}
	else
	{
		if (!$attachment['in_message'])
		{
			src_download_handle_forum_auth($db, $auth, $attachment['topic_id']);

			$sql = 'SELECT forum_id, post_visibility
				FROM ' . POSTS_TABLE . '
				WHERE post_id = ' . (int) $attachment['post_msg_id'];
			$result = $db->sql_query($sql);
			$post_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$post_row || ($post_row['post_visibility'] != ITEM_APPROVED && !$auth->acl_get('m_approve', $post_row['forum_id'])))
			{
				// Attachment of a soft deleted post and the user is not allowed to see the post
				send_status_line(404, 'Not Found');
				trigger_error('ERROR_NO_ATTACHMENT');
			}
		}
		else
		{
			// Attachment is in a private message.
			$post_row = array('forum_id' => false);
			src_download_handle_pm_auth($db, $auth, $user->data['user_id'], $attachment['post_msg_id']);
		}

		$extensions = array();
		if (!extension_allowed($post_row['forum_id'], $attachment['extension'], $extensions))
		{
			send_status_line(403, 'Forbidden');
			trigger_error(sprintf($user->lang['EXTENSION_DISABLED_AFTER_POSTING'], $attachment['extension']));
		}
	}

	$download_mode = (int) $extensions[$attachment['extension']]['download_mode'];
	$display_cat = $extensions[$attachment['extension']]['display_cat'];

	if (($display_cat == ATTACHMENT_CATEGORY_IMAGE || $display_cat == ATTACHMENT_CATEGORY_THUMB) && !$user->optionget('viewimg'))
	{
		$display_cat = ATTACHMENT_CATEGORY_NONE;
	}

	if ($display_cat == ATTACHMENT_CATEGORY_FLASH && !$user->optionget('viewflash'))
	{
		$display_cat = ATTACHMENT_CATEGORY_NONE;
	}

	if ($thumbnail)
	{
		$attachment['physical_filename'] = 'thumb_' . $attachment['physical_filename'];
	}
	else if ($display_cat == ATTACHMENT_CATEGORY_NONE && !$attachment['is_orphan'] && !src_http_byte_range($attachment['filesize']))
	{
		// Update download count
		src_increment_downloads($db, $attachment['attach_id']);
	}

	if ($display_cat == ATTACHMENT_CATEGORY_IMAGE && $mode === 'view' && (strpos($attachment['mimetype'], 'image') === 0) && (strpos(strtolower($user->browser), 'msie') !== false) && !src_is_greater_ie_version($user->browser, 7))
	{
		wrap_img_in_html(append_sid($src_root_path . 'download/file.' . $phpEx, 'id=' . $attachment['attach_id']), $attachment['real_filename']);
		file_gc();
	}
	else
	{
		// Determine the 'presenting'-method
		if ($download_mode == PHYSICAL_LINK)
		{
			// This presenting method should no longer be used
			if (!@is_dir($src_root_path . $config['upload_path']))
			{
				send_status_line(500, 'Internal Server Error');
				trigger_error($user->lang['PHYSICAL_DOWNLOAD_NOT_POSSIBLE']);
			}

			redirect($src_root_path . $config['upload_path'] . '/' . $attachment['physical_filename']);
			file_gc();
		}
		else
		{
			send_file_to_browser($attachment, $config['upload_path'], $display_cat);
			file_gc();
		}
	}
}
