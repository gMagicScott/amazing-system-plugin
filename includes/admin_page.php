<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Amazing System Administraiton</h2>
	
	<?php print $msg; ?>
	
	<form action="" method="post" id="amazing_system_form">
		<h3><label for="shortcode_name">Shortcode Name</label></h3>
		<p>Define the shortcode that will be used to trigger the retrieval of Amazing System variables, e.g. <code>[<strong>as</strong> what="Name"]</code><br />
		<input type="text" id="shortcode_name" name="shortcode_name" value="<?php print $shortcode_name ?>" /></p>
		<p class="submit"><input type="submit" name="submit" value="Update" /></p>
		<?php wp_nonce_field('amazing_system_options_update','amazing_system_admin_nonce'); ?>
	</form>
</div>