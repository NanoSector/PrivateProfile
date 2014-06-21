<?php

if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF'))
	die('<b>Error:</b> Cannot install - please verify you put this file in the same place as SMF\'s SSI.php.');

global $smcFunc, $user_info;

if((SMF == 'SSI') && !$user_info['is_admin'])
	die('Admin priveleges required.');

db_extend('packages');

$smcFunc['db_add_column'](
	'{db_prefix}members',
	array(
		'name' => 'profile_private',
		'type' => 'text',
	)
);
$smcFunc['db_add_column'](
	'{db_prefix}members',
	array(
		'name' => 'pp_ignore',
		'type' => 'tinyint',
	)
);

$smcFunc['db_query']('', '
	UPDATE {db_prefix}members
	SET profile_private = {string:def}',
	array(
		'def' => 'members'
	));
	
updateSettings(array(
	'pp_override_stats' => true,
	'pp_override_posts' => true,
	'pp_default' => 'members'
));
	
add_integration_function('integrate_admin_include', '$sourcedir/Subs-PrivateProfile.php');
add_integration_function('integrate_general_mod_settings', 'pp_settings');
add_integration_function('integrate_load_permissions', 'pp_permissions');