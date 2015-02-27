<?php

function as_switch_shortcode_cb ( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'default' => '',
		'field' => ''
		), $atts ) );
	// Now $default and $field are available.

	/**
	 * Exit early if "field" isn't defined.
	 */
	if ( '' == $field ) {
		global $post;
		if ( current_user_can('edit_post', $post->ID) ) {
			return '<code>Amazing System Plugin: "field" is required for the [switch] shortcode.</code>';
		} else {
			return '';
		}
	}

	$return  = $default;

	$request = MagicAmazingSystemPlugin::$request;

	foreach ($atts as $key => $value) {

		if ( 'default' == $key || 'field' == $key ) {
			unset( $atts[$key] );
		}
	}

	if (array_key_exists( 0, $atts)) {
		unset( $atts[0] );
	}

	foreach ($atts as $key => $value) {
		if ( 0 === $key ) {
			$key_strval = '0';
		} else {
			$key_strval = strval( $key );
		}

		if ( isset( $request[$field] ) && strtolower( $request[$field] ) === $key_strval ) {
			$return = $value;
			return $return;
		}

		if ( MagicAmazingSystemPlugin::is_a_default_1shop_field( $field ) ) {
			$atts[ 'field' ] = strtolower( $field );
			$atts[ 'default' ] = $default;
			$return = as_switch_shortcode_cb( $atts );
			continue;
		}
	}

	return $return;
}
