<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter('get_post_metadata', 'amsys_get__as_TY_URL', 10, 4);
function amsys_get__as_TY_URL( $return, $object_id, $meta_key, $single ) {

	if ( '_as_TY_URL' === $meta_key && '' === get_option( 'permalink_structure' ) ) {
		return array( 'You need to enable Pretty Permalinks.');
	}

	if ( '_as_TY_URL' === $meta_key ) {
		return array( trailingslashit( get_permalink() ) . '1shop.asp' );
	}

	return $return;
}
