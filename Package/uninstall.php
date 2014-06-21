<?php

if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF'))
	die('<b>Error:</b> Cannot install - please verify you put this file in the same place as SMF\'s SSI.php.');

global $smcFunc, $user_info;

if((SMF == 'SSI') && !$user_info['is_admin'])
	die('Admin priveleges required.');

db_extend('packages');

remove_integration_function('integrate_admin_include', '$sourcedir/Subs-PrivateProfile.php');
remove_integration_function('integrate_general_mod_settings', 'pp_settings');
remove_integration_function('integrate_load_permissions', 'pp_permissions');