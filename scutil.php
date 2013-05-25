<?php
/*
 Plugin Name: SCORM Cloud Utils
 Plugin URI: http://github.com/limikael/scutils
 Description: Extra stuff for integrating SCROM Cloud into Wordpress.
 Author: Mikael Lindqvist
 Version: 0.1
 Author URI: http://github.com/limikael/scutils
 */

require_once ABSPATH.'wp-admin/includes/plugin.php';

/**
 * Show error if scormcloud is missing.
 */
function scormcloud_missing_error() {
	echo '<div class="error"><p>';
	_e('The SCORM Cloud plugin is not activated, SCORM Cloud utils will not function without it.');
	echo '</p></div>';
}

if (!is_plugin_active("scormcloud/scormcloud.php")) {
	add_action('admin_notices','scormcloud_missing_error');
	return;
}

require_once __DIR__."/SCUtilPlugin.php";

$scutil=SCUtilPlugin::getInstance();

add_shortcode("scpreview",array($scutil,"scpreview"));
