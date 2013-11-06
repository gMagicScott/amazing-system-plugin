<?php
/**
* Amazing System
**/

require_once 'shortcode-switch.php';
require_once 'shortcode-get-current-version.php';

if ( is_admin() ) {
	require AMAZINGSYSTEM_PLUGIN_DIR . 'includes/tinymce-button.php';
}

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
			self::$request = array_merge( self::$request, $get );
		}
		if ( isset($_POST) ) {
			$post = $_POST;
			self::$request = array_merge( self::$request, $post );
		}
	}

		/**
		* Register used shortcodes
		*/
		public static function register_shortcodes()	{
		$shortcode = get_option(self::option_key, self::default_shortcode_name);
			add_shortcode ( $shortcode, 'MagicAmazingSystemPlugin::display_get_post_vars' );
			add_shortcode ( 'gender', 'MagicAmazingSystemPlugin::as_shortcode_gender_cb' );
			add_shortcode ( 'show_as_form', 'MagicAmazingSystemPlugin::show_as_form_cb' );
			add_shortcode ( 'textarea', 'MagicAmazingSystemPlugin::textarea_cb');
			add_shortcode ( 'switch', 'as_switch_shortcode_cb');
			add_shortcode ( 'as_plugin_server_version', 'as_get_current_version_shortcode_cb');
		}

		/**
		* Returns the content of a $_GET or $_POST or $_SESSION variable, referenced via shortcode, e.g. put the
		* following in the content of a post or page:
		*     [as what="Name" default="default value" force="get/post"]
		*/
		public static function display_get_post_vars( $atts ) {
			$firstname = '';
			$lastname = '';
			extract( shortcode_atts( array(
											'what' => 'Name',
											'default' => '',
											), $atts ) ) ;

			/*if ( !isset( $_REQUEST['Name'] ) && isset( $_SESSION['Name'] ) ) {
				$_REQUEST['Name'] = $_SESSION['Name'];
				}*/

			$request = array();
			$request = self::$request;

			if ( $what == 'firstname' ) {
					if ( isset( $request['Name'] )) {
						list($firstname, $lastname) = explode(' ', $request['Name'], 2);
						return trim($firstname);
					}
					/*if ( isset( $_GET['Name'] )) {
						list($firstname, $lastname) = explode(' ', $_GET['Name'], 2);
						return trim($firstname);
					}*/
			} else if ( $what === 'lastname' ) {
				list($firstname, $lastname) = explode(' ', $request['Name'], 2);
				return trim($lastname);
			}
			if ( isset( $request[$what] )) {
				$value = $request[$what];
			} /*else if (isset( $_GET[$what])) {
				$value = $_GET[$what];
			} else if (isset( $_SESSION[$what])) {
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

		$return = '<textarea' . $atts_string . '>' . do_shortcode( $content ) . '</textarea>';
		return $return;
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
			// $success = "We have stopped wpautop!\n";
			// $content = $success . $content;
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

add_filter('the_content', 'MagicAmazingSystemPlugin::stop_html_filter', 9);
add_filter('the_content', 'MagicAmazingSystemPlugin::add_javascript_to_footer', 9);

require_once( 'meta-box/example-functions.php' );
