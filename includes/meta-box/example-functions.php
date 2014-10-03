<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_as_';

	$meta_boxes[] = array(
		'id'         => 'amazing_system',
		'title'      => 'Amazing System',
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Email Merge Link',
				'desc' => __( 'Use this link in your 1ShoppingCart autoresponder messages to merge in all the fields you&apos;ve used on this page.', 'amazing-system' ),
				'id' => $prefix . '1Shop_Link',
				'type' => 'text_disabled'
			),
			array(
				'name' => 'Form HTML',
				'desc' => 'Add all Amazing System form code here. Add this shortcode: <code>[show_as_form]</code> into the main post content where you want the form to appear.',
				'id'   => $prefix . 'the_form',
				'type' => 'textarea_code',
			),
			array(
				'name' => 'Amazing System Scripts',
				'desc' => 'More of the standard Amazing System scripts will be coming soon.',
				'id' => $prefix . 'test_multicheckbox',
				'type' => 'multicheck',
				'options' => array(
					// 'amsys-title-case' => 'Capitalization',
					'amsys-gen4-validator' => 'JavaScript Form Validator'
					// 'jquery-datepicker' => 'Date Picker',
				)
			),
			// array(
			// 	'name' => 'Capitalization Fields',
			// 	'desc' => 'What fields should be autocapitalized?',
			// 	'id' => $prefix . 'test_multicheckbox_cap',
			// 	'type' => 'multiselect_js',
      //   'row_class' => 'amsys_cap_settings'
			// ),
			array(
				'name' => 'Add extra JavaScript',
				'desc' => 'Add JavaScript to this page in the footer (perfect for validation). This will be wrapped in <code>&lt;script&gt;</code> tags and CDATA tags.',
				'id'   => $prefix . 'extra_js',
				'type' => 'textarea_code',
			),
			array(
				'name' => 'Disable HTML Filter',
				'desc' => '&nbsp;&nbsp;Prevent WordPress from modifying HTML inside the post.',
				'id'   => $prefix . 'filter_html',
				'type' => 'checkbox',
			)
		),
	);


	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}
