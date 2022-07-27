<?php
/*
 * Plugin Name: Kyani Custom Configuration - SAP
 * Description: This plugin creates custom post types, fields, and functionality needed by Kyani.
 * Version: 1.0
 * Author: Kyani Corp.
 * Author URI: https://kyani.com
 */

$kyani_plugin_includes = array(
	'/setup.php',
	'/meta-box.php',
	'/post-type.php',
	'/rest-api.php',
	'/country-switcher/country-switcher.php',
	'/dynamic-year.php'
);

foreach ($kyani_plugin_includes as $file) {
	require_once plugin_dir_path(__FILE__) . 'includes' . $file;
}
