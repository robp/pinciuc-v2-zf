<?php
	ini_set('include_path', '/home/robp/www.pinciuc.com/include:/home/robp/www.pinciuc.com/htdocs/template:'.ini_get('include_path'));
//	require_once('Smarty.class.php');
	require_once('functions.php');
	require_once('DB.php');
	require_once('User.php');

/*
	$smarty = new Smarty();
	$smarty_dir = '/home/robp/www.pinciuc.com/smarty/v2';
	$smarty->template_dir	= "$smarty_dir/templates/";
	$smarty->compile_dir	= "$smarty_dir/templates_c/";
	$smarty->config_dir	= "$smarty_dir/configs/";
	$smarty->cache_dir	= "$smarty_dir/cache/";
*/

	// cookie or caching headers seem to screw up
	// delivery of jpegs dynamically, causing the
	// IE save picture as function to convert the
	// image to a bmp. we need the session vars for
	// security purposes, however.
	//if (!$no_session)
		session_set_cookie_params(0, '/', 'pinciuc.com');
		session_start();
