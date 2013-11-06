<?php
/*
Plugin Name: Amazing System
Plugin URI: http://www.amazingsystemtraining.com
Description: Amazing System 5.0 (That thing from Dave Farr) - now for WordPress
Author: Scott Lesovic
Version: 0.3.1
Author URI: http://www.scottlesovic.com
*/

define('AMAZINGSYSTEM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define('AMAZINGSYSTEM_TINYMCE_JS', plugins_url( 'js/tinymce-button.js', __FILE__ ) );

include_once('includes/amazing-system.php');

add_action( 'plugins_loaded', 'MagicAmazingSystemPlugin::save_request_vars' );
add_action( 'init', 'MagicAmazingSystemPlugin::register_shortcodes' );
add_action( 'admin_menu', 'MagicAmazingSystemPlugin::create_admin_menu' );
add_filter( 'plugin_action_links', 'MagicAmazingSystemPlugin::add_plugin_settings_link', 10, 2 );
//add_action( 'add_meta_boxes', 'MagicAmazingSystemPlugin::create_meta_box' );

function amazing_system_add_endpoints() {
	add_rewrite_endpoint('.php', EP_PERMALINK | EP_PAGES); // Adds endpoint to permalinks and pages to allow .php extention
}
add_action( 'init', 'amazing_system_add_endpoints');

function amazing_system_installer() {
	amazing_system_add_endpoints();
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
register_activation_hook( __FILE__, 'amazing_system_installer' );


/**
* Register custom upgrades (non-WordPress hosted plugins)
*/
$this_file = __FILE__;
$update_check = "http://www.guilefulmagic.com/plugins/amazing-system-plugin.chk";
require_once('gill-updates.php');



/*EOF*/
