<?php
/**
* This is run only when this plugin is uninstalled. All cleanup code goes here.
*/

// Exit if accessed directly or if unintentional uninstall
if ( ! defined( 'ABSPATH' ) || ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

// Flush rewrite rules to kill the endpoint
global $wp_rewrite;
$wp_rewrite->flush_rules();
