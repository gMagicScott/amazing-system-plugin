<?php
/**
 * Amazing System Block Shortcode
 *
 * @package   Amazing_System
 * @author    Scott Lesovic <scott@scottlesovic.com>
 * @license   GPL-2.0+
 * @link      http://scottlesovic.com
 * @copyright 2013 Scott Lesovic
 */

class Amazing_System_Shortcode_Block {

	protected $shortcode_tag = 'block';

	protected static $instance = null;

	protected $pairs = array(
		'field' => '',
		'value' => '',
		'operator' => 'eq'   // Not used
	);

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 */
	private function __construct() {
		add_shortcode ( $this->shortcode_tag, array( $this, 'fire' ) );
	}


	/**
	 * Return an instance of this class.
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function fire( $atts, $content = null, $tag = "block" ) {

		global $post;

		$atts = $this->validate_attributes( $atts );

		if ( is_wp_error( $atts ) && current_user_can( 'edit_post', $post->ID ) ) {
			return '<code>' . $atts->get_error_message() . '</code>';
		} elseif ( is_wp_error( $atts ) ) {
			return;
		}

		if ( $this->should_be_shown( $atts['field'], $atts['value'] ) ) {
			return do_shortcode( $content );
		}

		return;
	}

	private function validate_attributes( $atts ) {

		$clean = shortcode_atts( $this->pairs, $atts, $this->shortcode_tag);

		if ( '' === $clean['field'] ) {
			return new WP_Error( 'amazing_system_shortcode_block_field_empty',
				'Amazing System Plugin: "field" is required for the [block] shortcode.' );
		}

		if ( '' === $clean['value'] ) {
			return new WP_Error( 'amazing_system_shortcode_block_field_empty',
				'Amazing System Plugin: "value" is required for the [block] shortcode.' );
		}

		return $clean;
	}

	private function should_be_shown( $field, $value ) {

		$request = MagicAmazingSystemPlugin::$request;

		if ( !isset( $request[ $field ] ) ) {
			return false;
		}

		$request = $request[ $field ];

		if ( $value !== $request ) {
			return false;
		}

		return true;
	}


}
