<?php
/**
 * Main Options File
 *
 * @package CADesignSystem
 */

add_action( 'admin_menu', 'cagov_admin_menu' );

/**
 * Administration Menu Setup
 * Fires before the administration menu loads in the admin.
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_menu/
 * @return void
 */
function cagov_admin_menu() {
	add_menu_page(
		__( 'CA Design System', 'cagov' ),
		__( 'CA Design System', 'cagov' ),
		'manage_options',
		'ca-design-system',
		'cagov_render_admin_page',
		'dashicons-schedule',
		3
	);
}


	/**
	 * Render main landing page for CA Design System admin page.
	 */
function cagov_render_admin_page() {
	$vm_nonce = wp_create_nonce( 'volunteer_match_settings' );

	// if saving.
	if ( isset( $_POST['cagov_submit'] ) ) {
		cagov_save_options( $_POST );
	}

	$cagov_force_post_title = get_option( 'cagov_force_post_title', true );
	?>

		<h2>CA Design System</h2>
		<div>
			<p>Welcome to the CA Design System.</p>

			<ul>
				<li><a href="#content-guide">Content Guide</a></li>
				<li><a href="#creating-pages">Creating templated pages</a></li>
				<li><a href="#report-bug">Report a bug</a></li>
			</ul>

			<form id="cagov-options-form" action="<?php print esc_url( admin_url( 'admin.php?page=ca-design-system' ) ); ?>" method="POST">
				<div>
				<label for="cagov_force_post_title">Force Post/Page Title <input type="checkbox" id="cagov_force_post_title" name="cagov_force_post_title"<?php echo $cagov_force_post_title ? ' checked' : ''; ?>/></label>
				</div>
				<input type="submit" value="Save Changes" name="cagov_submit">
			</form>
		</div>
		<?php
}

/**
 * Save Options
 *
 * @param  array $values Option values.
 *
 * @return void
 */
function cagov_save_options( $values = array() ) {
	update_option( 'cagov_force_post_title', isset( $values['cagov_force_post_title'] ) );
}
