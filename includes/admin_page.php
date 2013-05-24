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
	<p>To pass form information into your WordPress site from 1ShoppingCart, you will need to use this &quot;hack.&quot;</p>
	<p>Set the following URL as your thank-you page on your form:</p>
	<p><code><?php print WP_PLUGIN_URL ?>/amazing-system/post.php</code></p>
	<p>Put the thank you page you want visitors to see within this next snippit in your form. Replace <em>your-url-here</em> with your thank you page.</p>
	<p><code>&lt;input type=&quot;hidden&quot; id=&quot;wpsys&quot; name=&quot;wpsys&quot; value=&quot;<em>your-url-here</em>&quot; /&gt;</code></p>
	<p>A better solution would be native 1ShoppingCart support. I have a idea request in. Please <a href="http://ideas.1shoppingcart.com/forums/20399-big-ideas/suggestions/2787097-send-post-variables-to-wordpress-based-thank-you-p">go here to vote and comment</a>. I'd appreciate it.</p>
</div>