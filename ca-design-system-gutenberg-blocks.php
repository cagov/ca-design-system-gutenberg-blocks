<?php

/**
 * Plugin Name: CA Design System Gutenberg Blocks
 * Plugin URI: TBD
 * Description: Gutenberg blocks to be used in WordPress that are compatible with the California's design system
 * Author: Office of Digital Innovation
 * Author URI: 
 * Version: 1.0.5
 * License: TBD
 * License URI: TBD
 * Text Domain: ca-design-system
 * 
 * @package ca-design-system
 * 
 */

if (!defined('ABSPATH')) {
    exit;
}
// Constants
define('CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__VERSION', '1.0.4');
define('CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH', plugin_dir_path(__FILE__));
define('CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__ADMIN_URL', plugin_dir_url(__FILE__));
define('CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__FILE', __FILE__);

add_action('admin_init', 'ca_design_system_gutenberg_blocks_admin_init');

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
function ca_design_system_gutenberg_blocks_admin_init()
{
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/core/class-ca-design-system-gutenberg-blocks-plugin-update.php';
}

if (!class_exists('CADesignSystemGutenbergBlocks')) {
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/includes/class-ca-design-system-gutenberg-blocks.php';
}

if (!class_exists('CADesignSystemGutenbergBlocks_AdminPage')) {
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/includes/class-ca-design-system-gutenberg-blocks-admin-page.php';
}

if (!class_exists('CADesignSystemGutenbergBlocks_Plugin_Templates_Loader')) {
    include_once CA_DESIGN_SYSTEM_GUTENBERG_BLOCKS__BLOCKS_DIR_PATH . '/includes/class-ca-design-system-gutenberg-blocks-templates.php';
}

CADesignSystemGutenbergBlocks::get_instance();
CADesignSystemGutenbergBlocks_AdminPage::get_instance();
CADesignSystemGutenbergBlocks_Plugin_Templates_Loader::get_instance();
