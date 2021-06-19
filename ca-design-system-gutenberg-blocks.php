<?php

/**
 * Plugin Name: CA Design System Gutenberg Blocks
 * Plugin URI: https://github.com/cagov/ca-design-system-gutenberg-blocks
 * Description: Gutenberg blocks for CA Design System
 * Author: Office of Digital Innovation
 * Author URI: https://digital.ca.gov
 * Version: 1.0.7
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: ca-design-system
 *
 * @category CADesignSystem
 * @package  CADesignSystem
 * @author   Office of Digital Innovation <info@digital.ca.gov>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/cagov/ca-design-system-gutenberg-blocks#readme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Constants
define( 'CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__VERSION', '1.0.7' );
define( 'CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__FILE', __FILE__ );

/**
 * Plugin API/Action Reference
 * Actions Run During a Typical Request
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference#Actions_Run_During_a_Typical_Request
 */
add_action( 'init', 'cagov_init' );
add_action( 'wp_enqueue_scripts', 'cagov_wp_enqueue_scripts', 100 );

/**
 * Plugin API/Action Reference
 * Actions Run During an Admin Page Request.
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference#Actions_Run_During_an_Admin_Page_Request
 */
add_action( 'admin_init', 'cagov_admin_init' );

/* Include Gutenberg Functionality */
require_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/blocks/gutenberg.php';

/**
 * CADesignSystem Init
 * Triggered before any other hook when a user accesses the admin area.
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 *
 * @category add_action( 'init', 'cagov_init' );
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
 * @return void
 */
function cagov_init() {
	/* Include Functionality */
	foreach ( glob( __DIR__ . '/includes/*.php' ) as $file ) {
		require_once $file;
	}

	register_nav_menu( 'content-menu', 'Content Menu' );
}

/**
 * Admin Init
 *
 * Triggered before any other hook when a user accesses the admin area.
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 *
 * @link   https://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
 * @return void
 */
function cagov_admin_init() {
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/core/class-ca-design-system-gutenberg-blocks-plugin-update.php';
}

function cagov_wp_enqueue_scripts() {
    global $post;
	
	$user_selected_template = get_page_template_slug( $post->ID );
	$file_name              = pathinfo( $user_selected_template, PATHINFO_BASENAME );
	$template_dir           = CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . 'templates/';

    // Only enqueue styles on pages using plugin templates.
	if ( ! is_dir( $template_dir . $file_name ) && file_exists( $template_dir . $file_name ) ) {
        
    }
	wp_register_style( 'ca-design-system-gutenberg-blocks-page', CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/page.css', false, '1.0.7.2' );
    wp_enqueue_style( 'ca-design-system-gutenberg-blocks-page' );
    
    wp_register_style( 'ca-design-system-gutenberg-blocks-announcement', CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/announcement.css', false, '1.0.6' );
    wp_enqueue_style( 'ca-design-system-gutenberg-blocks-announcement' ); // Default post

}
