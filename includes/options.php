<?php

/**
 * Main Options File
 *
 * @package CADesignSystem
 */

// add_action('admin_menu', 'cagov_admin_menu');

/**
 * Administration Menu Setup
 * Fires before the administration menu loads in the admin.
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_menu/
 * @return void
 */
function cagov_admin_menu()
{
	add_menu_page(
		__('CA Design System', 'cagov'),
		__('CA Design System', 'cagov'),
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
function cagov_render_admin_page()
{
?>

	<h2>CA Design System</h2>
	<div>
		<p>Greetings!</p>


	</div>
<?php
}
