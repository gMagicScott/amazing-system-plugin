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