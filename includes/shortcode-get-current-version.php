<?php

function as_get_current_version_shortcode_cb ( $atts = null, $content = null ) {
	// Get any existing copy of our transient data
	if ( false === ( $as_plugin_server_version = get_transient( 'as_plugin_server_version' ) ) ) {

		// It wasn't there, so regenerate the data and save the transient
		$response = wp_remote_get( 'http://www.guilefulmagic.com/plugins/amazing-system-plugin.chk' );

		if( is_wp_error( $response ) ) {
			echo 'Version Data Unavailable. Try again later.';
		} else {
			list($as_plugin_server_version, $url) = explode('|', $response['body']);
			set_transient( 'as_plugin_server_version', $as_plugin_server_version, 60*60*3 );
		}
	}

	return $as_plugin_server_version;
}
