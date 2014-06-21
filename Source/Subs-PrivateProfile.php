<?php

function pp_settings(&$config_vars)
{
    global $txt, $smcFunc;
    $ppsettings = array(
		array('select', 'pp_default', array('none' => $txt['pp_none'], 'guests' => $txt['pp_guests'], 'members' => $txt['pp_members'], 'buddies' => $txt['pp_buddies'], 'everyone' => $txt['pp_everyone'])),
		array('check', 'pp_allow_override'),
		array('var_message', 'pp_override'),
		array('check', 'pp_override_stats'),
		array('check', 'pp_override_posts'),
		'',
		array('select', 'pp_reset', array('none' => $txt['pp_dont'], 'guests' => $txt['pp_guests'], 'members' => $txt['pp_members'], 'buddies' => $txt['pp_buddies'], 'everyone' => $txt['pp_everyone'])),
		array('select', 'pp_reset_ignore', array('none' => $txt['pp_dont'], 'on' => $txt['enabled'], 'off' => $txt['disabled']))
    );
        
    $config_vars = array_merge($config_vars, $ppsettings);
	if (isset($_GET['save']) && !empty($_POST['pp_reset']) && in_array($_POST['pp_reset'], array('guests', 'members', 'buddies', 'everyone')))
	{
		$result = $smcFunc['db_query']('', '
			UPDATE {db_prefix}members
			SET profile_private = {string:pp}',
			array(
				'pp' => $_POST['pp_reset'],
			));
	}
	if (isset($_GET['save']) && !empty($_POST['pp_reset_ignore']) && in_array($_POST['pp_reset_ignore'], array('off', 'on')))
	{
		$smcFunc['db_query']('', '
			UPDATE {db_prefix}members
			SET pp_ignore = {int:ns}',
			array(
				'ns' => $_POST['pp_reset_ignore'] == 'on' ? 1 : 0,
			));
	}
	
	// Make sure this is always empty.
	$_POST['pp_reset'] = '';
	$_POST['pp_reset_ignore'] = '';
}

function pp_permissions(&$permissionGroups, &$permissionList)
{
	// Permission groups...
	$permissionGroups['membergroup']['simple'] = array('pp_simple');
	$permissionGroups['membergroup']['classic'] = array('pp_classic');

	$permissionList['membergroup']['pp_do_private_profile'] = array(false, 'pp_classic', 'pp_simple');
}