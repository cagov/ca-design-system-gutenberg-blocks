<?php

/**
 * Plugin Name: CA Design System Gutenberg Blocks
 * Plugin URI: https://github.com/cagov/ca-design-system-gutenberg-blocks
 * Description: Gutenberg blocks for CA Design System
 * Author: Office of Digital Innovation
 * Author URI: https://digital.ca.gov
 * Version: 1.0.9
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: ca-design-system
 *
 * @package  CADesignSystem
 * @author   Office of Digital Innovation <info@digital.ca.gov>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/cagov/ca-design-system-gutenberg-blocks#readme
 */

if (!defined('ABSPATH')) {
	exit;
}

// Constants.
define('CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__VERSION', '1.0.9');
define('CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH', plugin_dir_path(__FILE__));
define('CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL', plugin_dir_url(__FILE__));
define('CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__FILE', __FILE__);

/**
 * Plugin API/Action Reference
 * Actions Run During a Typical Request
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference#Actions_Run_During_a_Typical_Request
 */
add_action('init', 'cagov_init');
add_action('wp_enqueue_scripts', 'cagov_wp_enqueue_scripts', 100);
add_action('enqueue_block_editor_assets', 'cagov_wp_enqueue_editor_scripts');

/**
 * Plugin API/Action Reference
 * Actions Run During an Admin Page Request.
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference#Actions_Run_During_an_Admin_Page_Request
 */
add_action('admin_init', 'cagov_admin_init');


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
function cagov_init()
{
	/* Include Functionality */
	foreach (glob(__DIR__ . '/includes/*.php') as $file) {
		require_once $file;
	}

	register_nav_menu('content-menu', 'Content Menu');
}

/**
 * Admin Init
 *
 * Triggered before any other hook when a user accesses the admin area.
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 *
 * @category add_action( 'init', 'cagov_admin_init' );
 * @link   https://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
 * @return void
 */
function cagov_admin_init()
{
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/core/class-ca-design-system-gutenberg-blocks-plugin-update.php';
}

/**
 * Register CADesignSystem scripts/styles with priority of 100
 *
 * Fires when scripts and styles are enqueued.
 *
 * @category add_action( 'wp_enqueue_scripts', 'cagov_wp_enqueue_scripts', 100 );
 * @link https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
 *
 * @return void
 */
function cagov_wp_enqueue_scripts()
{
	wp_register_style('ca-design-system-gutenberg-blocks-page', CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/page.css', false, '1.0.9');
	wp_enqueue_style('ca-design-system-gutenberg-blocks-page');
}

/**
 * Registers an editor stylesheet for the current theme.
 * Editor styles: in editor.css. 
 * Typography and styles are re-implemented for the editor. 
 * Editor CSS needs to target specific block editor classes and can't be neatly inherited or overwritten using the stored files.
 * Notes: 
 * A reset file unsets typography properties like font size, weight, line height color, etc.
 * Reset file cannot be dequeued, and also is a good baseline reset for GB anyways (avoiding other CSS from other plugins) - so we will use this editor file styles our interface.
 * Our content css should be split out completely from theme CSS.
 * We might be able to try something more streamlined with SCSS, but need to dig out all the class handlers for GB first to understand the best strategy on resetting.
 */
function cagov_wp_enqueue_editor_scripts()
{
	wp_enqueue_style('ca-design-system-gutenberg-blocks-editor',  CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL . 'styles/editor.css', false);
}

if (!class_exists('CADesignSystemGutenbergBlocks_Plugin_Templates_Loader')) {
	include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/includes/class-ca-design-system-gutenberg-blocks-templates.php';
}

CADesignSystemGutenbergBlocks_Plugin_Templates_Loader::get_instance();
