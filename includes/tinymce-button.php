<?php
// registers the buttons for use
function register_as_tinymce_button($buttons) {
	// inserts a separator between existing buttons and our new one
	// "as_shortcode_btn" is the ID of our button
	array_push($buttons, "|", "as_shortcode_btn");
	return $buttons;
}

// filters the tinyMCE buttons and adds our custom buttons
function amazingsystem_shortcode_buttons() {
	// Don't bother doing this stuff if the current user lacks permissions
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	// Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
		// filter the tinyMCE buttons and add our own
		add_filter("mce_external_plugins", "add_amazingsystem_tinymce_plugin");
		add_filter('mce_buttons', 'register_as_tinymce_button');
	}
}
// init process for button control
add_action('init', 'amazingsystem_shortcode_buttons');

// add the button to the tinyMCE bar
function add_amazingsystem_tinymce_plugin($plugin_array) {
	$plugin_array['as_shortcode_btn'] = AMAZINGSYSTEM_TINYMCE_JS;
	return $plugin_array;
}

add_action( 'admin_enqueue_scripts', 'amsys_tinymce_data', 11 );
function amsys_tinymce_data ( $hook ) {
	$hooks = array( 'post.php', 'post-new.php', 'page-new.php', 'page.php' );
	if ( in_array( $hook, $hooks ) ) {
		wp_enqueue_script( 'amsys-zeroclipboard', plugins_url( 'js/ZeroClipboard.min.js', AMSYS_PLUGIN_FILE ), array( 'jquery' ), '2.1.6', true );
		$settings = get_option( 'amsys_settings' );
		$basic_merge_shortcode = $settings['basic_merge_shortcode'] ? $settings['basic_merge_shortcode'] : 'as';
		wp_localize_script(
			'cmb-scripts',
			'amsys_tinymce_data',
			array(
				'merge_shortcode' => $basic_merge_shortcode,
				'merge_fields' => $settings['1shop_fields'],
				'ZeroClipboardConfig' => array(
					'swfPath' => AMSYS_PLUGIN_URL . 'misc/ZeroClipboard.swf'
				)
			)
		);
	}
}

$_GLOBALS['amsys_shortcode_fields'] = array();

add_action('edit_form_top', 'amsys_link_generator', 10, 1);
function amsys_link_generator ( $post ) {
	global $shortcode_tags;
	global $amsys_shortcode_fields;

	$cached_tags = $shortcode_tags;

	$settings = get_option( 'amsys_settings' );
	$basic_merge_shortcode = $settings['basic_merge_shortcode'] ? $settings['basic_merge_shortcode'] : 'as';

	if ( has_shortcode( $post->post_content, $basic_merge_shortcode ) ) {
		remove_all_shortcodes();
		add_shortcode( $basic_merge_shortcode, 'amsys_shortcode_link_builder' );
		add_shortcode( 'gender', 'amsys_shortcode_link_builder' );
		add_shortcode( 'switch', 'amsys_shortcode_link_builder' );
		add_shortcode( 'block', 'amsys_shortcode_link_builder' );
		do_shortcode( $post->post_content );

		$the_form = get_post_meta( $post->ID, '_as_the_form', true );
		do_shortcode( $the_form );

		$the_extra_js = get_post_meta( $post->ID, '_as_extra_js', true );
		do_shortcode( $the_extra_js );

		foreach ($amsys_shortcode_fields as $key => $value ) {
			if ( 'firstname' === $value || 'mc-firstname' === $value || 'lastname' === $value || 'mc-lastname' === $value ) {
				$amsys_shortcode_fields[] = 'Name';
				unset( $amsys_shortcode_fields[ $key ] );
			}
		}
		$amsys_shortcode_fields = array_unique( $amsys_shortcode_fields);

		$post_url = get_permalink( $post->ID );

		$url_query = array();

		foreach ($amsys_shortcode_fields as $field) {
			$url_query[ urlencode( $field ) ] = amsys_get_1shop_code( $field );
		}

		$email_link = add_query_arg( $url_query, $post_url );

		// Do something with $email_link. It's good to go.
		$old_email_link = get_post_meta( $post->ID, '_as_1Shop_Link', true );
		update_post_meta( $post->ID, '_as_1Shop_Link', $email_link, $old_email_link );

		// Restore Shortcodes
		remove_all_shortcodes();
		$shortcode_tags = $cached_tags;

	}
	// die();
}


function amsys_shortcode_link_builder( $atts, $content = null ) {
	global $amsys_shortcode_fields;

	if ( isset( $atts['what'] ) ) {
		$amsys_shortcode_fields[] = $atts['what'];
	} elseif ( isset( $atts['field'] ) ) {
		$amsys_shortcode_fields[] = $atts['field'];
	} elseif ( isset( $atts['req'] ) ) {
		$amsys_shortcode_fields[] = $atts['req'];
	} elseif ( isset( $atts['field'] ) ) {
		$amsys_shortcode_fields[] = $atts['field'];
	}

	return '';

}

function amsys_get_1shop_code( $field ) {
	switch ($field) {

		case 'Name':
		case 'firstname':
		case 'lastname':
			return '%$Name$%';
			break;

		case 'Email1':
		case 'Company':
		case 'Homephone':
		case 'Workphone':
		case 'Fax':
		case 'Address1':
		case 'Address2':
		case 'City':
		case 'State':
		case 'Zip':
		case 'Country':
			return '%$' . $field . '$%';
			break;

		default:
			return '%$custom:' . $field . '$%';
			break;
	}
}
