<?php
/**
 * The Amazing System WordPress Plugin.
 *
 * @package   Amazing System
 * @author    Scott Lesovic <scott@scottlesovic.com>
 * @license   GPL-2.0+
 * @link      http://amazingsystemtraining.com/as-wordpress-plugin/
 * @copyright 2014 David Farr Direct and Scott Lesovic
 *
 * @wordpress-plugin
 * Plugin Name:      Amazing System
 * Plugin URI:       http://amazingsystemtraining.com/as-wordpress-plugin/
 * Description:      If you haven&apos;t heard, back in 1999, magician David Farr created a powerful strategy using internet technology to book shows on his website. They call it the <strong>Amazing System</strong>. You should try it &mdash; its, you know, <em>amazing</em>&hellip;
 * Version:          0.5.0-rc.2
 * Author:           Scott Lesovic
 * Author URI:       http://scottlesovic.com
 * Text Domain:      amazing-system
 * License:          GPL-2.0+
 * License URI:      http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:      /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'AMSYS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'AMSYS_PLUGIN_FILE', __FILE__ );
define( 'AMSYS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'AMAZINGSYSTEM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AMAZINGSYSTEM_TINYMCE_JS', plugins_url( 'js/tinymce-button.js', __FILE__ ) );

require_once( AMSYS_PLUGIN_PATH . 'includes/amazing-system.php' );

add_action( 'plugins_loaded',      'MagicAmazingSystemPlugin::save_request_vars' );
add_action( 'init',                'MagicAmazingSystemPlugin::register_shortcodes' );
add_action( 'admin_menu',          'MagicAmazingSystemPlugin::create_admin_menu' );
add_filter( 'plugin_action_links', 'MagicAmazingSystemPlugin::add_plugin_settings_link', 10, 2 );

/**
 * Register the '.php' endpoint
 *
 * 1ShoppingCart won't send POST form data to thank-you pages unless it sees '.php' or
 * '.asp' at the end of the URL. It's dumb, but we need to allow for our pages to use it.
 */
add_action( 'init', 'amazing_system_add_endpoints');
function amazing_system_add_endpoints() {
	add_rewrite_endpoint( '.php', EP_PERMALINK | EP_PAGES );
	add_rewrite_endpoint( '1shop.asp', EP_PERMALINK | EP_PAGES );
}

/**
 * Prevent trailing slash redirect on our endpoint
 *
 * See previous note about 1ShoppingCart. Anyways, WordPress will try to redirect
 * `http://example.com/my-page/.php` to `http://example.com/my-page/.php/` to keep
 * the URLs looking pretty.
 *
 * When you do a redirect on a request that has POST data, you loose it. Thus we
 * need to prevent WordPress from making this redirect.
 */
add_filter('redirect_canonical', 'amsys_no_trailing_slash', 10, 2);
function amsys_no_trailing_slash( $redirect_url, $requested_url ) {
	$is_our_endpoint = preg_match( '/\/(?:\.php|1shop\.asp)$/', $requested_url );
	$is_trailingslash_redirect = ( $redirect_url === trailingslashit( $requested_url ) ) ? true : false;
	if ( $is_our_endpoint && $is_trailingslash_redirect ) {
		// By returning false, the redirect is prevented
		return false;
	}
	// Not our endpoint, don't change anything
	return $redirect_url;
}

/**
 * What to do when WordPress activates our plugin
 *
 * We only need to add our endpoints and flush the rules.
 */
register_activation_hook( __FILE__, 'amazing_system_installer' );
function amazing_system_installer($network) {
	global $wp_rewrite;

	amazing_system_add_endpoints();
	$wp_rewrite->flush_rules();
}


/**
 * Run upgrade routine
 */
require AMSYS_PLUGIN_PATH . 'upgrade.php';
