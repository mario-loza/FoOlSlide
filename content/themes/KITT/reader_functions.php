<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * READER FUNCTIONS
 * 
 * This file allows you to add functions and plain procedures that will be 
 * loaded every time the public reader loads.
 * 
 * If this file doesn't exist, the default theme's reader_functions.php will
 * be loaded.
 *
 * For more information, refer to the support sites linked in your admin panel.
 */





/**
 * Returns the URL to the theme directory
 * 
 * @param string team name
 * @author Woxxy
 * @return string facebook widget for the team
 */
if(!function_exists('get_theme_dir'))
{
	function get_theme_dir() {
		return site_url().'content/themes/'.get_setting('fs_theme_dir').'/';
	}
}