<?php


/**
* @ignore
*/
if (!defined('IN_src'))
{
	exit;
}

/**
* Get user avatar
*
* @deprecated 3.1.0-a1 (To be removed: 3.3.0)
*
* @param string $avatar Users assigned avatar name
* @param int $avatar_type Type of avatar
* @param string $avatar_width Width of users avatar
* @param string $avatar_height Height of users avatar
* @param string $alt Optional language string for alt tag within image, can be a language key or text
* @param bool $ignore_config Ignores the config-setting, to be still able to view the avatar in the UCP
*
* @return string Avatar image
*/
function get_user_avatar($avatar, $avatar_type, $avatar_width, $avatar_height, $alt = 'USER_AVATAR', $ignore_config = false)
{
	// map arguments to new function src_get_avatar()
	$row = array(
		'avatar'		=> $avatar,
		'avatar_type'	=> $avatar_type,
		'avatar_width'	=> $avatar_width,
		'avatar_height'	=> $avatar_height,
	);

	return src_get_avatar($row, $alt, $ignore_config);
}

/**
* Hash the password
*
* @deprecated 3.1.0-a2 (To be removed: 3.3.0)
*
* @param string $password Password to be hashed
*
* @return string|bool Password hash or false if something went wrong during hashing
*/
function src_hash($password)
{
	global $src_container;

	$passwords_manager = $src_container->get('passwords.manager');
	return $passwords_manager->hash($password);
}

/**
* Check for correct password
*
* @deprecated 3.1.0-a2 (To be removed: 3.3.0)
*
* @param string $password The password in plain text
* @param string $hash The stored password hash
*
* @return bool Returns true if the password is correct, false if not.
*/
function src_check_hash($password, $hash)
{
	global $src_container;

	$passwords_manager = $src_container->get('passwords.manager');
	return $passwords_manager->check($password, $hash);
}

/**
* Eliminates useless . and .. components from specified path.
*
* Deprecated, use filesystem class instead
*
* @param string $path Path to clean
* @return string Cleaned path
*
* @deprecated
*/
function src_clean_path($path)
{
	global $src_path_helper, $src_container;

	if (!$src_path_helper && $src_container)
	{
		$src_path_helper = $src_container->get('path_helper');
	}
	else if (!$src_path_helper)
	{
		global $src_root_path, $phpEx;

		// The container is not yet loaded, use a new instance
		if (!class_exists('\src\path_helper'))
		{
			require($src_root_path . 'src/path_helper.' . $phpEx);
		}

		$request = new src\request\request();
		$src_path_helper = new src\path_helper(
			new src\symfony_request(
				$request
			),
			new src\filesystem(),
			$request,
			$src_root_path,
			$phpEx
		);
	}

	return $src_path_helper->clean_path($path);
}

/**
* Pick a timezone
*
* @param	string		$default			A timezone to select
* @param	boolean		$truncate			Shall we truncate the options text
*
* @return		string		Returns the options for timezone selector only
*
* @deprecated
*/
function tz_select($default = '', $truncate = false)
{
	global $template, $user;

	return src_timezone_select($template, $user, $default, $truncate);
}

/**
* Cache moderators. Called whenever permissions are changed
* via admin_permissions. Changes of usernames and group names
* must be carried through for the moderators table.
*
* @deprecated 3.1
* @return null
*/
function cache_moderators()
{
	global $db, $cache, $auth;
	return src_cache_moderators($db, $cache, $auth);
}

/**
* Removes moderators and administrators from foe lists.
*
* @deprecated 3.1
* @param array|bool $group_id If an array, remove all members of this group from foe lists, or false to ignore
* @param array|bool $user_id If an array, remove this user from foe lists, or false to ignore
* @return null
*/
function update_foes($group_id = false, $user_id = false)
{
	global $db, $auth;
	return src_update_foes($db, $auth, $group_id, $user_id);
}

/**
* Get user rank title and image
*
* @param int $user_rank the current stored users rank id
* @param int $user_posts the users number of posts
* @param string &$rank_title the rank title will be stored here after execution
* @param string &$rank_img the rank image as full img tag is stored here after execution
* @param string &$rank_img_src the rank image source is stored here after execution
*
* @deprecated 3.1.0-RC5 (To be removed: 3.3.0)
*
* Note: since we do not want to break backwards-compatibility, this function will only properly assign ranks to guests if you call it for them with user_posts == false
*/
function get_user_rank($user_rank, $user_posts, &$rank_title, &$rank_img, &$rank_img_src)
{
	global $src_root_path, $phpEx;
	if (!function_exists('src_get_user_rank'))
	{
		include($src_root_path . 'includes/functions_display.' . $phpEx);
	}

	$rank_data = src_get_user_rank(array('user_rank' => $user_rank), $user_posts);
	$rank_title = $rank_data['title'];
	$rank_img = $rank_data['img'];
	$rank_img_src = $rank_data['img_src'];
}
