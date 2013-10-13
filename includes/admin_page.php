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

	<h3>Amazing System Resources</h3>
	<ul>
		<li>Brush up on your Amazing System <em>know-how</em> at our <a href="http://amazingsystemtraining.com/">Training Resource Site</a>.</li>
		<li><strong>Need Help?</strong> If you have any questions or problems, please <a href="http://support.amazingsystem.com/">contact us</a>.</li>
	</ul>

</div>