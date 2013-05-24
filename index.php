<?php 
/*
Plugin Name: Amazing System
Plugin URI: http://www.amazingsystemtraining.com
Description: Amazing System 3.0 (That thing from Dave Farr) - now for WordPress
Author: Scott Lesovic
Version: 0.1.6
Author URI: http://www.scottlesovic.com
*/


include_once('includes/amazing-system.php');

add_action( 'init', 'MagicAmazingSystemPlugin::register_shortcodes' );
add_action( 'admin_menu', 'MagicAmazingSystemPlugin::create_admin_menu' );
add_filter( 'plugin_action_links', 'MagicAmazingSystemPlugin::add_plugin_settings_link', 10, 2 );
//add_action( 'add_meta_boxes', 'MagicAmazingSystemPlugin::create_meta_box' );

/**
* Register custom upgrades (non-WordPress hosted plugins)
*/
$this_file = __FILE__;
$update_check = "http://www.guilefulmagic.com/plugins/amazing-system-plugin.chk";
require_once('gill-updates.php');



/*EOF*/