<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Amazing System Administraiton</h2>
	
	<?php if ( isset( $msg ) ) {
		print $msg;
		} ?>
	
	<form action="" method="post" id="amazing_system_form">
		<h3><label for="shortcode_name">Shortcode Name</label></h3>
		<p>Define the shortcode that will be used to trigger the retrieval of Amazing System variables, e.g. <code>[<strong><?php print $shortcode_name ?></strong> what="Name"]</code><br />
		<input type="text" id="shortcode_name" name="shortcode_name" value="<?php print $shortcode_name ?>" /></p>
		<p class="submit"><input type="submit" name="submit" value="Update" /></p>
		<?php wp_nonce_field('amazing_system_options_update','amazing_system_admin_nonce'); ?>
	</form>
	<h3>The 1ShoppingCart WordPress Hack</h3>
	<p>I have reworked the plugin to no longer need the hack. Set your thank you page to the correct WordPress page.</p>
	<p>If you were already using the hack, please update your forms. The hack function will eventually be removed from the plugin.</p>
</div>