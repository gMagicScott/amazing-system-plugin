<?php
/**
* Amazing System
**/
class MagicAmazingSystemPlugin {
	public static $javascript = '';
	public static $request = array();	
	
	/**
	* Define Class Constants
	*/
	const default_shortcode_name = 'as';
	const option_key = 'amazing_system_shortcode';
	/**
	 * Save Get/Post/Session to class var for later use
	 */
	public static function save_request_vars() {
		if ( isset($_GET) ) {
			$get = $_GET;
			array_merge( self::$request, $get );
		}
		if ( isset($_POST) ) {
			$post = $_POST;
			array_merge( self::$request, $post );
		}
	}

		/**
		* Register used shortcodes
		*/
		public static function register_shortcodes()	{
		$shortcode = get_option(self::option_key, self::default_shortcode_name);
		add_shortcode ( $shortcode, 'MagicAmazingSystemPlugin::display_get_post_vars' );
		add_shortcode ( 'gender', 'MagicAmazingSystemPlugin::as_shortcode_gender_cb' );
		}

		/**
		* Returns the content of a $_GET or $_POST or $_SESSION variable, referenced via shortcode, e.g. put the
		* following in the content of a post or page:
		*     [as what="Name" default="default value" force="get/post"]	
		*
		*
		*/	
		public static function display_get_post_vars( $atts ) {
			extract( shortcode_atts( array(
											'what' => 'Name',
											'default' => '',
											), $atts ) ) ;

			/*if ( !isset( $_REQUEST['Name'] ) && isset( $_SESSION['Name'] ) ) {
				$_REQUEST['Name'] = $_SESSION['Name'];
				}*/
			if ( $what == 'firstname' ) {
					if ( isset( $_POST['Name'] )) {
						list($firstname, $lastname) = explode(' ', $_POST['Name'], 2);
						return trim($firstname);
					}
					if ( isset( $_GET['Name'] )) {
						list($firstname, $lastname) = explode(' ', $_GET['Name'], 2);
						return trim($firstname);
					}
			} else if ( $what === 'lastname' ) {
				list($firstname, $lastname) = explode(' ', self::$request['Name'], 2);
				return trim($lastname);
			}
			if ( isset( $_POST[$what] )) {
				$value = $_POST[$what];
			} else if (isset( $_GET[$what])) {
				$value = $_GET[$what];
			} /*else if (isset( $_SESSION[$what])) {
				$value = $_SESSION[$what];
			} */else {
				$value = $default;
			}

			return $value;
		}
	/**
	 * TODO: change 'req' to pull from an option
	 */
	public static function as_shortcode_gender_cb ( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'boy' => 'he',
			'girl' => 'she',
			'multi' => 'they',
			'req' => 'field8',
		), $atts ) );
		
		$r = $boy;
		
		if ( isset( $_REQUEST[$req] ) && 'girl' == $_REQUEST[$req] ) {
			return $girl;
		}
		if ( isset( $_REQUEST[$req] ) && 'multi' == $_REQUEST[$req] ) {
			return $multi;
		}
		
		return $r;
	}
	
	// Used to uniquely identify this plugin's menu page in the WP manager
	const admin_menu_slug = 'amazing_system';
	
	/**
	* Create admin menue
	*/
	public static function create_admin_menu() {
			add_menu_page(
				'Amazing System',		// page title
				'Amazing System',		// menu title
				'manage_options',		// capability
				self::admin_menu_slug,	// menu slug
				'MagicAmazingSystemPlugin::get_admin_page'	// callback
				);
	}

	/**
	* Prints the admininstration page for plugin.
	*/
	public static function get_admin_page()	{
	if ( !empty($_POST) && check_admin_referer('amazing_system_options_update','amazing_system_admin_nonce') )		{
			update_option( self::option_key, stripslashes( $_POST['shortcode_name'] ) );
			$msg = '<div class="updated"><p>Your settings have been <strong>updated</strong></p></div>';
		}
		
		$shortcode_name = esc_attr( get_option(self::option_key,self::default_shortcode_name) );
		include('admin_page.php');
	}

	/**
	* The inputs here come directly from WordPress:	
	* @param	array	$links - a hash in the format of name => trnaslation e.g.
	* 	array('deactivate' => 'Deactivate') that describes all links available to a plugin.	
	* @param	string	$file - the path to a plugin's main file (the one with the info header),
	*	relative to the plugins directory, e.g. 'amazing-system/index.php'
	* @return	array	The $links hash.
	*/

	public static function add_plugin_settings_link($links, $file) {
		if ( $file == 'amazing-system/index.php' ) {
			$settings_link = sprintf ( '<a href="%s">%s</a>', admin_url ( 'options-general.php?page='.self::admin_menu_slug ), 'Settings' );
			array_unshift ( $links, $settings_link );
		}
		return $links;
	}


	/**
	 * Hooks into 'the_content' filter to stop wpautop.
	 *
	 * wpautop is the special WordPress filter that changes
	 * HTML in posts/pages so you don't break you website.
	 * In some cases we want to do advanced things inside
	 * a post or page. This will let us.
	 *
 	 * @param  string $content recieved from 'the_content' filter, not used
	 * @return string $content return content back to WordPress (unchanged)
	 */

	 public static function stop_html_filter( $content ) {
		global $post;
		$as_filter_html_value = get_post_meta($post->ID, '_as_filter_html', true);

		if ( '' != $as_filter_html_value && 'on' == $as_filter_html_value ) {
			remove_filter('the_content', 'wpautop');
			remove_filter('the_excerpt', 'wpautop');
			remove_filter('the_content', 'wptexturize');
			remove_filter('the_excerpt', 'wptexturize');
			// $success = "We have stopped wpautop!\n";
			// $content = $success . $content;
		}
		return $content;
	}

	public static function add_javascript_to_footer($content) {
		global $post;
		$as_extra_js_value = get_post_meta( $post->ID, '_as_extra_js', true);

		if ( '' == $as_extra_js_value ) {
			return $content;
		}

		$javascript = <<<EOF
		<script type="text/javascript">	
		// <![CDATA[
		$as_extra_js_value
		// ]]>
		</script>
EOF;

		self::$javascript = $javascript;
		add_action('wp_footer', 'MagicAmazingSystemPlugin::js_footer_callback');
		return $content;
	}

	public static function js_footer_callback() {
		echo self::$javascript;
	}
}

add_action('init', 'MagicAmazingSystemPlugin::save_request_vars', 5);
add_filter('the_content', 'MagicAmazingSystemPlugin::stop_html_filter', 9);
add_filter('the_content', 'MagicAmazingSystemPlugin::add_javascript_to_footer', 9);
require_once( 'meta-box/example-functions.php' );
/*EOF*/