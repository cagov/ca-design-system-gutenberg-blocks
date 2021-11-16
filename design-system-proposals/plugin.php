<?php

/**
 * Plugin Name: Department of Cannabis Control WordPress customizations
 * Plugin URI: https://github.com/cagov/cagov-cannabis-headless-wordpress
 * Description: Add custom Gutenberg blocks
 * Author: Office of Digital Innovation
 * Author URI: https://digital.ca.gov
 * Version: 1.1.0
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: ca-design-system
 *
 * @package  CADesignSystemCannabis
 * @author   Office of Digital Innovation <info@digital.ca.gov>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/cagov/cagov-cannabis-headless-wordpress#README
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Plugin API/Action Reference
 * Actions Run During an Admin Page Request.
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference#Actions_Run_During_an_Admin_Page_Request
 */
// add_action('admin_init', 'cagov_cannabis_headless_wordpress_admin_init');

/**
 * Admin Init
 *
 * Triggered before any other hook when a user accesses the admin area.
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 * 
 * This pings the latest GitHub release and makes it available to plugin users to pull down changes.
 * For scheduling updates, please refer to GitHub. 
 * https://github.com/cagov/ca-design-system-gutenberg-blocks#README
 *
 * @category add_action( 'init', 'cagov_admin_init' );
 * @link   https://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
 * @return void
 */

 // @TODO Renable when this is own plugin (file name would need to change)
// function cagov_cannabis_headless_wordpress_admin_init()
// {
// 	include_once CAGOV_CANNABIS_HEADLESS_WORDPRESS__DIR_PATH . '/core/class-cagov-cannabis-headless-wordpress-update.php';
// }

// Plugin Constants.
define('CAGOV_CANNABIS_HEADLESS_WORDPRESS__VERSION', '1.0.0');
define('CAGOV_CANNABIS_HEADLESS_WORDPRESS__DIR_PATH', plugin_dir_path(__FILE__));
define('CAGOV_CANNABIS_HEADLESS_WORDPRESS__ADMIN_URL', plugin_dir_url(__FILE__));
define('CAGOV_CANNABIS_HEADLESS_WORDPRESS__FILE', __FILE__);

/**
 * Initialize Gutenberg blocks
 */
// add_action('init', 'cagov_cannabis_library_init');
/* Include Gutenberg blocks and patterns. */
require_once CAGOV_CANNABIS_HEADLESS_WORDPRESS__DIR_PATH . '/blocks/plugin.php';

// Add page templates
// if (!class_exists('CADesignSystemGutenbergBlocks_Plugin_Templates_Loader')) {
// 	include_once CAGOV_CANNABIS_HEADLESS_WORDPRESS__DIR_PATH . '/includes/class-cagov-cannabis-headless-wordpress-templates.php';
// }

// CADesignSystemGutenbergBlocks_Plugin_Templates_Loader::get_instance();
