<?php
/**
* Amazing System
**/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

require_once( AMSYS_PLUGIN_PATH . 'includes/shortcode-switch.php' );
require_once( AMSYS_PLUGIN_PATH . 'includes/shortcode-block.php' );
require_once( AMSYS_PLUGIN_PATH . 'includes/shortcode-get-current-version.php' );

if ( is_admin() ) {
	require AMSYS_PLUGIN_PATH . 'includes/tinymce-button.php';
}

class MagicAmazingSystemPlugin {

	public static $javascript = '';
	public static $request = array();
	public static $blog_charset = '';

	/**
	* Define Class Constants
	*/
	const default_shortcode_name = 'as';
	const option_key = 'amazing_system_shortcode';

	/**
	 * Save Get/Post/Session to class var for later use
	 */
	public static function save_request_vars() {
		static $charset = 'ASCII, UTF-8, ISO-8859-1, JIS, EUC-JP, SJIS';

		self::$blog_charset = get_option( 'blog_charset' );

		$data = array();
		$data = isset( $_GET ) ? array_merge( $data, $_GET ) : $data;
		$data = isset( $_POST ) ? array_merge( $data, $_POST ) : $data;

		$clean_data = array();

		foreach ( $data as $key => $value ) {
			$clean_data[ $key ] = self::convert_encoding_deep(
				$value,
				self::$blog_charset,
				$charset
				);
		}

		self::$request = stripslashes_deep( $clean_data );
	}

	public static function convert_encoding_deep( $value, $blog_charset = false, $charset = 'ASCII, UTF-8, ISO-8859-1, JIS, EUC-JP, SJIS' )	{
		if ( false === $blog_charset ) {
			$blog_charset = self::$blog_charset;
		}
		if ( is_array( $value ) ) {
			$value = array_map( 'MagicAmazingSystemPlugin::convert_encoding_deep', $value );
		} elseif ( is_string( $value ) && function_exists( 'mb_convert_encoding' ) ) {
			$value = mb_convert_encoding(
				$value,
				$blog_charset,
				$charset
				);
		}

		return $value;
	}

		/**
		* Register used shortcodes
		*/
		public static function register_shortcodes()	{
			$settings = get_option( 'amsys_settings' );
			$basic_merge_shortcode = $settings['basic_merge_shortcode'] ? $settings['basic_merge_shortcode'] : 'as';

			add_shortcode ( $basic_merge_shortcode, 'MagicAmazingSystemPlugin::shortcode_merge_handler' );
			add_shortcode ( 'gender', 'MagicAmazingSystemPlugin::as_shortcode_gender_cb' );
			add_shortcode ( 'show_as_form', 'MagicAmazingSystemPlugin::show_as_form_cb' );
			add_shortcode ( 'textarea', 'MagicAmazingSystemPlugin::textarea_cb');
			add_shortcode ( 'switch', 'as_switch_shortcode_cb');
			add_shortcode ( 'as_plugin_server_version', 'as_get_current_version_shortcode_cb');
		}

		/**
		* Returns the content of a $_GET or $_POST or $_SESSION variable, referenced via shortcode, e.g. put the
		* following in the content of a post or page:
		*     [as what="Name" default="default value"]
		*/
		public static function shortcode_merge_handler( $atts ) {
			$default_atts = array(
				'what' => 'Name',
				'default' => ''
				);

			$settings = get_option( 'amsys_settings' );
			$shortcode_tag = $settings['basic_merge_shortcode'] ? $settings['basic_merge_shortcode'] : 'as';

			$atts = shortcode_atts( $default_atts, $atts, $shortcode_tag );

			$field = $atts[ 'what' ];
			$default_value = $atts[ 'default' ];

			if ( 'Name' == $field || 'name' == $field ) {
				return self::get_full_name( $default_value );
			}

			if ( 'firstname' == $field || 'mc-firstname' == $field ) {
				return self::get_firstname( $default_value );
			}

			if ( 'lastname' == $field || 'mc-lastname' == $field ) {
				return self::get_lastname( $default_value );
			}

			if ( isset( self::$request[ $field ] ) && !empty( self::$request[ $field ] ) ) {
				return trim( self::$request[ $field ] );
			}

			return $default_value;
		}

		/**
		 * Get client's full name
		 *
		 * Parse the request to build out the client's full name from avaliable fields.
		 *
		 * @param  string $default Value to use if unable to retrieve full name
		 * @return string          The value to replace the shortcode tag
		 */
		private static function get_full_name( $default ) {
			if ( self::get_firstname( false ) && self::get_lastname( false ) ) {
				return self::get_firstname( '' ) . ' ' . self::get_lastname( '' );
			} elseif ( self::get_firstname( false ) ) {
				return self::get_firstname( '' );
			}

			return $default;
		}

		/**
		 * Get client's first name
		 *
		 * Parse the request to build out the client's first name from avaliable fields.
		 *
		 * @param  string $default Value to use if unable to retrieve first name
		 * @return string          The value to replace the shortcode tag
		 */
		private static function get_firstname( $default ) {
			if ( isset( self::$request[ 'mc-firstname' ] ) && !empty( self::$request[ 'mc-firstname' ] ) ) {
				return trim( self::$request[ 'mc-firstname' ] );
			}

			if ( isset( self::$request[ 'Name' ] ) && !empty( self::$request[ 'Name' ] ) ) {
				$name_array = explode( ' ', self::$request[ 'Name' ] );
				return trim( $name_array[0] );
			}

			return $default;
		}

		/**
		 * Get client's last name
		 *
		 * Parse the request to build out the client's last name from avaliable fields.
		 *
		 * @param  string $default Value to use if unable to retrieve last name
		 * @return string          The value to replace the shortcode tag
		 */
		private static function get_lastname( $default ) {}

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
		$request = array();
		$request = self::$request;

		if ( isset( $request[$req] ) && 'girl' == $request[$req] ) {
			return $girl;
		}
		if ( isset( $request[$req] ) && 'multi' == $request[$req] ) {
			return $multi;
		}

		return $r;
	}

	/**
	 * Handler for [show_as_form] shortcode.
	 */
	public static function show_as_form_cb( $atts, $content = null) {
		global $post;
		$as_form_html_value = get_post_meta( $post->ID, '_as_the_form', true);

		if ( '' == $as_form_html_value ) {
			return $content;
		}

		/**
		 * WordPress function `is_plugin_active` only in "admin" area
		 *
		 * To do this test on the front end (as we are in this short code)
		 * we have to make sure the file containing the function is loaded.
		 *
		 * GitHub: Issue #4
		 */
		if ( !function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		if ( is_plugin_active( 'kswp_pop_wizard/kswp_pop_wizard.php' ) ) {
			global $kswp_pop_wizard_var;
			$as_form_html_value = $kswp_pop_wizard_var->kswp_pop_wizard_tooltip_html_js( $as_form_html_value );
		}

		return do_shortcode( $as_form_html_value );
	}

	/**
	 * Handler for [textarea][/textarea] shortcode
	 *
	 * When using the standard HTML tag for textareas, the containing
	 * form get broken out of. This shortcode will create a normal
	 * textarea tag when viewed in the page output, but stops the problem
	 * in the admin area.
	 *
	 * @param  array $atts    attributes contained in opening tag
	 * @param  string $content data contained between open and closed [textarea][/textarea]
	 * @return string          the html output
	 */
	public static function textarea_cb( $atts, $content = '') {
		$atts = shortcode_atts( array(

			// textarea specific
			'autofocus' => '',
			'cols' => '',
			'disabled' => '',
			'form' => '',
			'maxlength' => '',
			'name' => '',
			'placeholder' => '',
			'readonly' => '',
			'required' => '',
			'rows' => '',
			'wrap' => '',

			// global attributes
			'accesskey' => '',
			'class' => '',
			'contenteditable' => '',
			'contextmenu' => '',
			'dir' => '',
			'draggable' => '',
			'dropzone' => '',
			'hidden' => '',
			'id' => '',
			'lang' => '',
			'spellcheck' => '',
			'style' => '',
			'tabindex' => '',
			'title' => '',

			// event attributes
			'onblur' => '',
			'onchange' => '',
			'oncontextmenu' => '',
			'onfocus' => '',
			'onformchange' => '',
			'onforminput' => '',
			'oninput' => '',
			'oninvalid' => '',
			'onselect' => '',
			'onsubmit' => '',
			'onkeydown' => '',
			'onkeypress' => '',
			'onkeyup' => '',
			'onclick' => '',
			'ondblclick' => '',
			'ondrag' => '',
			'ondragend' => '',
			'ondragenter' => '',
			'ondragleave' => '',
			'ondragover' => '',
			'ondragstart' => '',
			'ondrop' => '',
			'onmousedown' => '',
			'onmousemove' => '',
			'onmouseout' => '',
			'onmouseover' => '',
			'onmouseup' => '',
			'onmousewheel' => '',
			'onscroll' => '',
		), $atts );

		$atts_string = '';

		if ( !empty($atts) ) {
			foreach ($atts as $k => $v) {
				$append = '';

				if ( '' != $v ) {
					$append = ' ' . $k . '="' . esc_attr( $v ) . '"';
				}

				$atts_string .= $append;
			} // End foreach
		} // End If

		$return = '<textarea' . $atts_string . '>' . esc_textarea( do_shortcode( $content ) ) . '</textarea>';
		return $return;
	}

	// Used to uniquely identify this plugin's menu page in the WP manager
	const admin_menu_slug = 'amazing_system';

	/**
	* Create admin menue
	*/
	public static function create_admin_menu() {
			add_menu_page(
				'Amazing System Administration',		// page title
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
		$settings = get_option( 'amsys_settings' );

		if ( !empty($_POST) && check_admin_referer('amazing_system_options_update','amazing_system_admin_nonce') && current_user_can('manage_options') )		{
			$settings['basic_merge_shortcode'] = stripslashes($_POST['shortcode_name']);
			$settings['1shop_fields'] = stripslashes_deep( $_POST['merge_fields'] );
			update_option( 'amsys_settings', $settings );
			$msg = '<div class="updated"><p>Your settings have been <strong>updated</strong></p></div>';
		}

		$basic_merge_shortcode = $settings['basic_merge_shortcode'] ? $settings['basic_merge_shortcode'] : 'as';

		$shortcode_name = esc_attr( $basic_merge_shortcode );
		unset($basic_merge_shortcode);
		include( AMAZINGSYSTEM_PLUGIN_DIR . 'includes/admin_page.php' );
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
		if ( $file == 'amazing-system/amazing-system.php' ) {
			$settings_link = sprintf ( '<a href="%s">%s</a>', admin_url ( 'admin.php?page='.self::admin_menu_slug ), 'Settings' );
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
		}
		return $content;
	}

	public static function add_javascript_to_footer($content) {
		global $post;

		$as_extra_js_value = get_post_meta( $post->ID, '_as_extra_js', true);
		$as_extra_js_value = do_shortcode( $as_extra_js_value );

		if ( '' == $as_extra_js_value ) {
			return $content;
		}

		$javascript = <<<EOF
		<script type="text/javascript">
		/* <![CDATA[ */
		$as_extra_js_value
		/* ]]> */
		</script>
EOF;

		self::$javascript = $javascript;
		add_action('wp_footer', 'MagicAmazingSystemPlugin::js_footer_callback', 20 );
		return $content;
	}

	public static function js_footer_callback() {
		echo self::$javascript;
	}
}

add_action( 'wp_enqueue_scripts', 'amsys_maybe_enqueue_validator' );
function amsys_maybe_enqueue_validator () {
	global $post;

	wp_register_script( 'amsys-gen4-validator', plugins_url( 'js/gen_validatorv4.js', AMSYS_PLUGIN_FILE ), array(), '4.0', true );

	if ( is_singular() ) {
		$scripts = get_post_meta( $post->ID, '_as_test_multicheckbox', false );

		foreach ($scripts as $script) {
			if ( wp_script_is( $script, 'registered' ) ) {
				wp_enqueue_script( $script );
			}
		}
	}
}


add_filter('the_content', 'MagicAmazingSystemPlugin::stop_html_filter', 9);
add_filter('the_content', 'MagicAmazingSystemPlugin::add_javascript_to_footer', 9);

add_action( 'init', array( 'AmSys_Shortcode_Block', 'get_instance' ) );

require_once( AMSYS_PLUGIN_PATH . 'includes/meta-box/example-functions.php' );
