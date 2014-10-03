<?php
// Check that the user is allowed to update options
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

?>
<div class="wrap">
	<style type="text/css">
	.amsys_get_skinny {
		width: 100px;
	}
	</style>

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php if ( isset( $msg ) ) {
		print $msg;
		} ?>
	<form action="" method="post" id="amazing_system_form">

		<h3><label for="shortcode_name">Shortcode Name</label></h3>

		<p>Define the shortcode that will be used to trigger the retrieval of Amazing System variables, e.g. <code>[<strong><?php print $shortcode_name ?></strong> what="Name"]</code><br />

		<input type="text" id="shortcode_name" name="shortcode_name" value="<?php print $shortcode_name ?>" /></p>

		<h3>1ShoppingCart Fields</h3>
		<table class="wp-list-table widefat">
			<thead>
				<tr>
					<th class="amsys_get_skinny">#</th>
					<th>Field Shortname</th>
					<!-- <th>Email Merge Tag</th> -->
					<th>Description</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="amsys_get_skinny">#</th>
					<th>Field Shortname</th>
					<!-- <th>Email Merge Tag</th> -->
					<th>Description</th>
				</tr>
			</tfoot>
			<tbody>
			<?php
			$_count = 0;
			foreach ($settings['1shop_fields'] as $key => $value) {
				$_count++;
				if ( 0 === $_count % 2) {
					echo '<tr>';
				} else {
					echo '<tr class="alternate">';
				}
			?>
					<th class="amsys_get_skinny"><small><strong><?php
					if ( preg_match( '/default-\d+/', $key ) ) {
						echo 'Default Field';
					} else {
						echo 'Custom Field ' . ($_count - 12);
					}
					?></strong></small></th>
					<td><input class="widefat" type="text" name="merge_fields[<?php echo $key; ?>][shortname]" value="<?php echo esc_attr( $value['shortname'] ); ?>"></td>
					<!-- <td><input type="text" name="merge_fields[<?php echo $key; ?>][mergetag]" value="<?php echo esc_attr( $value['mergetag'] ); ?>"></td> -->
					<td><input class="widefat" type="text" name="merge_fields[<?php echo $key; ?>][description]" value="<?php echo esc_attr( $value['description'] ); ?>"></td>
				</tr>
			<?php }
			?>

			</tbody>
		</table>

		<p class="submit"><input type="submit" name="submit" value="Save Settings" class="button button-primary" /></p>

		<?php wp_nonce_field('amazing_system_options_update','amazing_system_admin_nonce'); ?>

	</form>

	<h3>Amazing System Resources</h3>
	<ul>
		<li>Brush up on your Amazing System <em>know-how</em> at our <a href="http://amazingsystemtraining.com/">Training Resource Site</a>.</li>
		<li><strong>Need Help?</strong> If you have any questions or problems, please <a href="http://support.amazingsystem.com/">contact us</a>.</li>
	</ul>

</div>
