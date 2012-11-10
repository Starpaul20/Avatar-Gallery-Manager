<?php
/**
 * Avatar Gallery Manager
 * Copyright 2012 Starpaul20
 */

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// Tell MyBB when to run the hooks
$plugins->add_hook("admin_user_menu", "avatargallerymanager_admin_menu");
$plugins->add_hook("admin_user_action_handler", "avatargallerymanager_admin_action_handler");
$plugins->add_hook("admin_user_permissions", "avatargallerymanager_admin_permissions");
$plugins->add_hook("admin_tools_get_admin_log_action", "avatargallerymanager_admin_adminlog");

// The information that shows up on the plugin manager
function avatargallerymanager_info()
{
	return array(
		"name"				=> "Avatar Gallery Manager",
		"description"		=> "Allows you to manage the avatar gallery from your Admin CP.",
		"website"			=> "http://galaxiesrealm.com/index.php",
		"author"			=> "Starpaul20",
		"authorsite"		=> "http://galaxiesrealm.com/index.php",
		"version"			=> "1.0",
		"guid"				=> "cb61d6ca48136224c95ee2f7bcc19f45",
		"compatibility"		=> "16*"
	);
}

// This function runs when the plugin is activated.
function avatargallerymanager_activate()
{
	change_admin_permission('user', 'avatar_gallery');
}

// This function runs when the plugin is deactivated.
function avatargallerymanager_deactivate()
{
	change_admin_permission('user', 'avatar_gallery', -1);
}

// Admin CP avatar gallery page
function avatargallerymanager_admin_menu($sub_menu)
{
	global $lang;
	$lang->load("user_avatar_gallery");

	$sub_menu['110'] = array('id' => 'avatar_gallery', 'title' => $lang->avatar_gallery, 'link' => 'index.php?module=user-avatar_gallery');

	return $sub_menu;
}

function avatargallerymanager_admin_action_handler($actions)
{
	$actions['avatar_gallery'] = array('active' => 'avatar_gallery', 'file' => 'avatar_gallery.php');

	return $actions;
}

function avatargallerymanager_admin_permissions($admin_permissions)
{
  	global $db, $mybb, $lang;
	$lang->load("user_avatar_gallery");

	$admin_permissions['avatar_gallery'] = $lang->can_manage_avatar_gallery;

	return $admin_permissions;
}

// Admin Log display
function avatargallerymanager_admin_adminlog($plugin_array)
{
  	global $lang;
	$lang->load("user_avatar_gallery");

	if($plugin_array['lang_string'] == admin_log_user_avatar_gallery_add_avatar)
	{
		if(!$plugin_array['logitem']['data'][1])
		{
			$plugin_array['lang_string'] = admin_log_user_avatar_gallery_add_avatar_default;
		}
	}

	elseif($plugin_array['lang_string'] == admin_log_user_avatar_gallery_edit_avatar)
	{
		if(!$plugin_array['logitem']['data'][1])
		{
			$plugin_array['lang_string'] = admin_log_user_avatar_gallery_edit_avatar_default;
		}
	}

	elseif($plugin_array['lang_string'] == admin_log_user_avatar_gallery_delete_avatar)
	{
		if(!$plugin_array['logitem']['data'][1])
		{
			$plugin_array['lang_string'] = admin_log_user_avatar_gallery_delete_avatar_default;
		}
	}

	return $plugin_array;
}

?>